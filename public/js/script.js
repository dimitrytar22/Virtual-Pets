document.addEventListener('DOMContentLoaded', function () {
    const selectContainer = document.querySelector('.select-container');
    const selectSelected = selectContainer.querySelector('.select-selected');
    const selectItems = selectContainer.querySelector('.select-items');
    const hiddenSelect = selectContainer.querySelector('select');

    // Обработчик клика на выбранное значение
    selectSelected.addEventListener('click', function () {
        selectItems.classList.toggle('select-show');
    });

    // Обработчик клика на элемент списка
    selectItems.addEventListener('click', function (e) {
        if (e.target.classList.contains('select-item')) {
            const value = e.target.getAttribute('data-value');
            const imgSrc = e.target.getAttribute('data-img');
            const text = e.target.textContent;

            // Обновляем отображение выбранного элемента
            selectSelected.querySelector('img').src = imgSrc;
            selectSelected.querySelector('span').textContent = text;

            // Обновляем скрытый селект
            hiddenSelect.value = value;

            // Скрываем список
            selectItems.classList.add('select-hide');
        }
    });

    // Скрываем список, если клик вне его
    document.addEventListener('click', function (e) {
        if (!selectContainer.contains(e.target)) {
            selectItems.classList.add('select-hide');
        }
    });
});
