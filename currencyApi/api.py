from mysql.connector import errorcode
import mysql.connector
import requests
import pprint


DB_NAME = 'currency'

r = requests.get('https://tw.rter.info/capi.php')
currency = r.json()

# pprint.pprint(currency)

twM = currency['USDTWD']['Exrate']
for key, value in currency.items():
    value['newExrate'] = round(twM / value['Exrate'], 3)
    value['twExrate'] = round(value['Exrate'] / twM, 3)

# 建立陣列
arrCurrency = [
    ['美國', currency['USDUSD']['newExrate'], 'USD', '美元',
        '#007ab04f', currency['USDUSD']['twExrate']],
    ['中國', currency['USDCNH']['newExrate'], 'CNH', '人民幣',
        '#37b03536', currency['USDCNH']['twExrate']],
    ['日本', currency['USDJPY']['newExrate'], 'JPY', '日圓',
        '#007ab04f', currency['USDJPY']['twExrate']],
    ['韓國', currency['USDKRW']['newExrate'], 'KRW', '韓圓',
        '#37b03536', currency['USDKRW']['twExrate']],
    ['香港', currency['USDHKD']['newExrate'], 'HKD', '港幣',
        '#007ab04f', currency['USDHKD']['twExrate']],
    ['義大利', currency['USDEUR']['newExrate'], 'EUR', '歐元',
        '#37b03536', currency['USDEUR']['twExrate']],
    ['澳洲', currency['USDAUD']['newExrate'], 'AUD', '澳元',
        '#007ab04f', currency['USDAUD']['twExrate']],
    ['泰國', currency['USDTHB']['newExrate'], 'THB', '泰銖',
        '#37b03536', currency['USDTHB']['twExrate']],
    ['新加坡', currency['USDSGD']['newExrate'], 'SGD', '新加坡幣',
        '#007ab04f', currency['USDSGD']['twExrate']],
    ['馬來西亞', currency['USDMYR']['newExrate'], 'MYR', '令吉',
        '#37b03536', currency['USDMYR']['twExrate']],
    ['越南', currency['USDVND']['newExrate'], 'VND', '越南盾',
        '#007ab04f', currency['USDVND']['twExrate']],
    ['印尼', currency['USDIDR']['newExrate'], 'IDR', '印尼盾',
        '#37b03536', currency['USDIDR']['twExrate']]
]


try:
    cnx = mysql.connector.connect(user='root',
                                  password='',
                                  host='127.0.0.1',
                                  )
except mysql.connector.Error as err:
    if err.errno == errorcode.ER_ACCESS_DENIED_ERROR:
        print("Something is wrong with your user name or password")
    elif err.errno == errorcode.ER_BAD_DB_ERROR:
        print("Database does not exist")
    else:
        print(err)
else:
    print('成功連線')

cursor = cnx.cursor()


def create_database(cursor):
    try:
        cursor.execute(
            "CREATE DATABASE {} DEFAULT CHARACTER SET 'utf8mb4'".format(DB_NAME))
    except mysql.connector.Error as err:
        print("Failed creating database: {}".format(err))
        exit(1)


try:
    cursor.execute("USE {}".format(DB_NAME))
except mysql.connector.Error as err:
    print("Database {} does not exists.".format(DB_NAME))
    if err.errno == errorcode.ER_BAD_DB_ERROR:
        create_database(cursor)
        print("Database {} created successfully.".format(DB_NAME))
        cnx.database = DB_NAME
    else:
        print(err)
        exit(1)


# Creating table

TABLES = {}
TABLES['currencys'] = (
    "CREATE TABLE currencys ("
    " `id` int AUTO_INCREMENT,"
    " `nation` varchar(10) NOT NULL,"
    " `nation_change_tw` decimal(10,3) NOT NULL,"
    " `tw_change_nation` decimal(10,3) NOT NULL,"
    " `date` timestamp NOT NULL DEFAULT current_timestamp(),"
    " PRIMARY KEY (`id`)"
    ") ENGINE=InnoDB")


for table_name in TABLES:
    table_description = TABLES[table_name]
    try:
        print("Creating table {}: ".format(table_name), end='')
        cursor.execute(table_description)
    except mysql.connector.Error as err:
        if err.errno == errorcode.ER_TABLE_EXISTS_ERROR:
            print("already exists.")
        else:
            print(err.msg)
    else:
        print("OK")


add_currencys = ("INSERT INTO currencys "
                 "(nation, nation_change_tw, tw_change_nation) "
                 "VALUES (%s, %s, %s)")

for i in arrCurrency:

    data_currencys = (i[3], i[1], i[5])

    cursor.execute(add_currencys, data_currencys)


print('closing')

# Commit the transaction
cnx.commit()

# Close the cursor and connection
cursor.close()
cnx.close()

print('Transaction committed and connection closed.')
