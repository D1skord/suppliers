/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';

const $ = require('jquery');
global.$ = global.jQuery = $;


require('bootstrap');




require('inputmask/dist/jquery.inputmask');
import Cookies from 'js-cookie';

require('datatables.net');

import jsZip from 'jszip';

require('datatables.net-bs4');
require('datatables.net-buttons-bs4');
require('datatables.net-responsive-bs4');
require('datatables.net-buttons/js/buttons.print.js');
require('datatables.net-buttons/js/buttons.colVis.js');
require('datatables.net-buttons/js/buttons.flash.js');
require('datatables.net-buttons/js/buttons.html5.js');

//
//


require('datatables.net-searchpanes-bs4');
require('datatables.net-select-bs4');

window.JSZip = jsZip;
$(function () {
    "use strict";

    // Add active state to sidbar nav links
    var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
    $("#layoutSidenav_nav .sb-sidenav a.nav-link").each(function () {
        if (this.href === path) {
            $(this).addClass("active");
            $(this).parent().parent().addClass("show");
            let parentId = $(this).parent().parent().attr('id');
            let $parentElem = $(`a[data-target="#${parentId}"]`);
            $parentElem.addClass("active").addClass("show");

        }
    });

    // Toggle the side navigation
    $("#sidebarToggle").on("click", function (e) {
        e.preventDefault();
        $("body").toggleClass("sb-sidenav-toggled");
    });

    /* DataTable */
    let dataTableLang = {
        "aria": {
            "SortAscending": ": activate to sort column ascending",
            "SortDescending": ": activate to sort column descending"
        },
        "paginate": {
            "first": "Первая",
            "last": "Последняя",
            "next": "Следующая",
            "previous": "Предыдущая"
        },
        "emptyTable": "Нет данных",
        "info": "Показано с _START_ по _END_ из _TOTAL_ записей",
        "infoEmpty": "",
        "infoFiltered": "(общее количество: _MAX_)",
        "lengthMenu": "Показывать _MENU_ записей",
        "loadingRecords": "Загрузка...",
        "processing": "Обработка...",
        "search": "Поиск:",
        "zeroRecords": "Данные не найдены"
    };

    // Таблица поставщиков
    $('#suppliersTable').DataTable({
        "language": dataTableLang,
        "bFilter": true,
        "oSearch": {"bSmart": false, "bRegex": true},
        "aoColumns": [
            {"mData": "name", "bSortable": false},
            null,
            null,
            null,
            null,
        ],
        columnDefs: [
            {orderable: false, sortable: false, targets: [0, 1, 2, 3]}
        ]
    });
    $('.dataTables_length').addClass('bs-select');


    // Таблица товаров
    $('#productsTable').DataTable({
        "language": dataTableLang,
        "bFilter": true,
        "oSearch": {"bSmart": false, "bRegex": true},
        "aoColumns": [
            {"bSearchable": false},
            {"sType": "html"},
            {"sType": "html"},
            {"sType": "html"},
            {"sType": "html"},
            {"bSearchable": false},
            {"bSearchable": false},
            {"bSearchable": false},
            {"bSearchable": false},
            {"bSearchable": false},
            {"bSearchable": false},
            {"bSearchable": false},
            {"bSearchable": false},
        ],
        columnDefs: [
            {orderable: false, sortable: false, targets: [0, 1, 3, 7, 8, 9, 10, 11]}
        ]

    });
    $('.dataTables_length').addClass('bs-select');

    // Таблица товаров на странице товаров
    $('#productsPageTable').DataTable({
        "language": dataTableLang,
        "bFilter": true,
        "oSearch": {"bSmart": false, "bRegex": true},
        "aoColumns": [
            {"bSearchable": false},
            {"sType": "html"},
            {"sType": "html"},
            {"sType": "html"},
            {"sType": "html"},
            {"bSearchable": false},
            {"bSearchable": false},
            {"bSearchable": false},
            {"bSearchable": false},
            {"bSearchable": false},
            {"bSearchable": false},
            {"bSearchable": false},
            {"bSearchable": false},
            {"bSearchable": false},
        ],
        columnDefs: [
            {orderable: false, sortable: false, targets: [0, 1, 3, 7, 8, 9, 10, 11, 12]}
        ],

    });
    $('.dataTables_length').addClass('bs-select');


    // Таблица заявки
    $('.request-table').DataTable({
        "language": dataTableLang,
        "bFilter": true,
        "oSearch": {"bSmart": false, "bRegex": true},
        "aoColumns": [
            {"bSearchable": false},
            {"sType": "html"},
            {"sType": "html"},
            {"sType": "html"},
            {"sType": "html"},
            {"bSearchable": false},
            {"bSearchable": false},
            {"bSearchable": false},
            {"bSearchable": false},
            {"bSearchable": false},
            {"bSearchable": false},
            {"bSearchable": false},
            {"bSearchable": false},
            {"bSearchable": false},
        ],
        columnDefs: [
            {orderable: false, sortable: false, targets: [0, 1, 3, 7, 8, 9, 10, 11, 12]}
        ],

        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Data export'
            },
        ],


    });
    /* /DataTable */

    // Спрашивать перед удалением
    $('.delete-object-btn').on('click', function () {
        return confirm("Вы уверены, что хотите удалить объект?");
    });

    // Маска для input с телефоном
    $('.phone-mask').inputmask({"mask": "+7 (999) 999-99-99"});

    // Добавляем размер контейнера, если он выбран в кор. сист.
    $('#add_supplier_product_form_root').on('change', function () {
        let rootText = $(this).find("option:selected").text();

        let $containerField = $('#add_supplier_product_form_containerSize');
        if (rootText === 'Контейнер') {
            $containerField.parent().removeClass('d-none');
        } else {
            $containerField.val('');
            $containerField.parent().addClass('d-none');
        }
    });

    /* Корзина */

    // Добавление/Удаление
    $('.btn-product-cart').on('click', function () {
        let btnStatuses = {
            add: {text: 'В корзину', class: 'btn-primary'},
            delete: {text: 'Из корзины', class: 'btn-success'}
        };

        let cart = Cookies.get('cart');
        let productId = $(this).data('product-id');

        if (!cart) {
            cart = '{}';
        }
        let jsonCart = JSON.parse(cart);
        let $carCount = $('#cartLink').find('.cart-count');

        //  Если товар уже в корзине, то удаляем
        if (jsonCart[productId]) {
            delete jsonCart[productId];
            $carCount.text(Number($carCount.text()) - 1);
        } else {
            jsonCart[productId] = {'id': productId, 'quantity': 1};
            $carCount.text(Number($carCount.text()) + 1);
        }

        // Записываем изменения в куки корзины
        Cookies.set('cart', JSON.stringify(jsonCart));

        // Если корзина, то перезагружаем страницу для обновления товаров
        if ($('.cart-page').length > 0) {
            location.reload();
            return true;
        }


        // Изменяем кнопки
        if ($(this).text() == btnStatuses.add.text) {
            $(this).text(btnStatuses.delete.text);
            $(this).addClass(btnStatuses.delete.class);
            $(this).removeClass(btnStatuses.add.class);
        } else {
            $(this).text(btnStatuses.add);
            $(this).text(btnStatuses.add.text);
            $(this).addClass(btnStatuses.add.class);
            $(this).removeClass(btnStatuses.delete.class);
        }
    });

    // Кол-во
    $('.product-quantity').on('change', function () {
        let cart = Cookies.get('cart'),
                jsonCart = JSON.parse(cart),
                productId = $(this).data('product-id');

        jsonCart[productId]['quantity'] = $(this).val();
        Cookies.set('cart', JSON.stringify(jsonCart));

        console.log(jsonCart);
    });

    /* /Корзина */


});




