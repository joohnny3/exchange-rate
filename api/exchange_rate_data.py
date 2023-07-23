from mysql.connector import errorcode
import mysql.connector
import requests
import pprint


DB_NAME = 'exchange_rate'

res = requests.get('https://tw.rter.info/capi.php')
exchange_rate = res.json()


exchangeTwd = exchange_rate['USDTWD']['Exrate']

for key, value in exchange_rate.items():
    value['newExrate'] = round(exchangeTwd / value['Exrate'], 3)
    value['twExrate'] = round(value['Exrate'] / exchangeTwd, 3)

# 建立陣列
arrCurrency = [
    ['美國', exchange_rate['USDUSD']['newExrate'], 'USD', '美元',
        '#007ab04f', exchange_rate['USDUSD']['twExrate'],1],
    ['中國', exchange_rate['USDCNH']['newExrate'], 'CNH', '人民幣',
        '#37b03536', exchange_rate['USDCNH']['twExrate'],2],
    ['日本', exchange_rate['USDJPY']['newExrate'], 'JPY', '日圓',
        '#007ab04f', exchange_rate['USDJPY']['twExrate'],3],
    ['韓國', exchange_rate['USDKRW']['newExrate'], 'KRW', '韓圓',
        '#37b03536', exchange_rate['USDKRW']['twExrate'],4],
    ['香港', exchange_rate['USDHKD']['newExrate'], 'HKD', '港幣',
        '#007ab04f', exchange_rate['USDHKD']['twExrate'],5],
    ['義大利', exchange_rate['USDEUR']['newExrate'], 'EUR', '歐元',
        '#37b03536', exchange_rate['USDEUR']['twExrate'],6],
    ['澳洲', exchange_rate['USDAUD']['newExrate'], 'AUD', '澳元',
        '#007ab04f', exchange_rate['USDAUD']['twExrate'],7],
    ['泰國', exchange_rate['USDTHB']['newExrate'], 'THB', '泰銖',
        '#37b03536', exchange_rate['USDTHB']['twExrate'],8],
    ['新加坡', exchange_rate['USDSGD']['newExrate'], 'SGD', '新加坡幣',
        '#007ab04f', exchange_rate['USDSGD']['twExrate'],9],
    ['馬來西亞', exchange_rate['USDMYR']['newExrate'], 'MYR', '令吉',
        '#37b03536', exchange_rate['USDMYR']['twExrate'],10],
    ['越南', exchange_rate['USDVND']['newExrate'], 'VND', '越南盾',
        '#007ab04f', exchange_rate['USDVND']['twExrate'],11],
    ['印尼', exchange_rate['USDIDR']['newExrate'], 'IDR', '印尼盾',
        '#37b03536', exchange_rate['USDIDR']['twExrate'],12]
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

TABLES['currency'] = (
    "CREATE TABLE currency ("
    "`id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,"
    "`currency` varchar(10) NOT NULL,"
    " PRIMARY KEY (`id`)"
    ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci")

TABLES['exchange_rates'] = (
    "CREATE TABLE exchange_rates ("
    "`id` int(10) NOT NULL AUTO_INCREMENT,"
    "`currency_id` int(10) UNSIGNED NOT NULL,"
    "`exchange_rate` decimal(10,3) NOT NULL,"
    "`create_time` timestamp NOT NULL DEFAULT current_timestamp(),"
    " PRIMARY KEY (`id`)"
    ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;")

TABLES['init_currency'] = (
    "INSERT INTO `currency` (`id`, `currency`) VALUES"
    "(1, '美元'),"
    "(2, '人民幣'),"
    "(3, '日圓'),"
    "(4, '韓圓'),"
    "(5, '港幣'),"
    "(6, '歐元'),"
    "(7, '澳元'),"
    "(8, '泰銖'),"
    "(9, '新加坡幣'),"
    "(10, '令吉'),"
    "(11, '越南盾'),"
    "(12, '印尼盾');")


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


add_currencys = ("INSERT INTO exchange_rates "
                 "(currency_id,exchange_rate) "
                 "VALUES (%s, %s)")

for i in arrCurrency:

    data_currencys = (i[6], i[1])

    cursor.execute(add_currencys, data_currencys)


print('closing')

# Commit the transaction
cnx.commit()

# Close the cursor and connection
cursor.close()
cnx.close()

print('Transaction committed and connection closed.')
