const changeBtn = document.querySelector('.navbar-brand');
const cardTextElements = document.querySelectorAll('.card-text');
const cardTitleElements = document.querySelectorAll('.card-title');
let isChanged = false;


changeBtn.addEventListener('click', () => {
  cardTextElements.forEach((element) => {
    if (!isChanged) {
      const changeTwWord = element.getAttribute('data-taiwna');
      element.setAttribute('data-original', element.innerHTML);
      element.innerHTML = changeTwWord;
    } else {
      element.innerHTML = element.getAttribute('data-original');
    }
  });

  
  cardTitleElements.forEach((element) => {
    if (!isChanged) {
      const changeNewWord = element.getAttribute('data-change');
      element.setAttribute('data-original', element.innerHTML);
      element.innerHTML = changeNewWord;
    } else {
      element.innerHTML = element.getAttribute('data-original');
    }
  });

  isChanged = !isChanged;
});