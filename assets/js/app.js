/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';
const $ = require('jquery');
require('bootstrap');
require('datatables.net');
require('inputmask/dist/jquery.inputmask');
import Cookies from 'js-cookie';



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
    $(document).ready(function () {
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
    });

    // Таблица товаров
    $(document).ready(function () {
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
    });

    // Таблица товаров на странице товаров
    $(document).ready(function () {
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
            ]

        });
        $('.dataTables_length').addClass('bs-select');
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
            add: {text: 'В корзину', class : 'btn-primary'},
            delete: {text: 'Из корзины', class : 'btn-success'}
        };
        console.log($(this).text() +'=='+ btnStatuses.add.text);
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
        let cart = Cookies.get('cart');
        let productId = $(this).data('product-id');

        if (!cart) {
            cart = '{}';
        }
        let jsonCart = JSON.parse(cart);
        if (jsonCart[productId]) {
            delete jsonCart[productId];
            alert("Товар удален из корзины!");
        } else {
            jsonCart[productId] = productId;
            alert("Товар добавлен в корзину!");
        }

        Cookies.set('cart', JSON.stringify(jsonCart));

        console.log(Cookies.get('cart'));
    });
    /* /Корзина */
});




