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

    // $('#layoutSidenav_content').on('click', function () {
    //     if (!$("body").hasClass('sb-sidenav-toggled')) {
    //         $("#sidebarToggle").click();
    //     }
    // });

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
        "search": "Общий фильтр:",
        "zeroRecords": "Данные не найдены"
    };

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
    var productsPageTable = $('#productsPageTable').DataTable({
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

    $('#searchByIdInput').on('keyup change', function () {
        productsPageTable.column(1).search(this.value).draw();
    });
    $('#searchByNameInput').on('keyup change', function () {
        productsPageTable.column(2).search(this.value).draw();
    });
    $('#searchByRootInput').on('keyup change', function () {
        productsPageTable.column(3).search(this.value).draw();
    });
    $('#searchByTypeInput').on('keyup change', function () {
        productsPageTable.column(4).search(this.value).draw();
    });

    var fixNewLine = {
        exportOptions: {
            format: {
                body: function (data, column, row) {
                    return data.replace(/<br\s*\/?>/ig, "\n");

                }
            }
        }
    };

    function columnToLetter(column) {
        var temp, letter = '';
        while (column > 0) {
            temp = (column - 1) % 26;
            letter = String.fromCharCode(temp + 65) + letter;
            column = (column - temp - 1) / 26;
        }
        return letter;
    }

    function remove_tags(html) {
        html = html.replace(/<br>/g, "$br$");
        html = html.replace(/(?:\r\n|\r|\n)/g, '$n$');
        var tmp = document.createElement("DIV");
        tmp.innerHTML = html;
        html = tmp.textContent || tmp.innerText;

        html = html.replace(/\$br\$/g, "<br>");
        html = html.replace(/\$n\$/g, "<br>");

        return html;
    }

    // Таблица заявки
    var table = $('.request-table').DataTable({
        "language": dataTableLang,
        "searching": false,
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
                action: function (e, dt, button, config) {
                    let newTitle = $(button).parent().parent().parent().parent().parent().find('.request-title').text();
                    config.title = newTitle;
                    $.fn.dataTable.ext.buttons.excelHtml5.action(e, dt, button, config);
                },
                text: 'Excel',
                exportOptions: {
                    format: {
                        body: function (data, row, column, node) {

                            //need to change double quotes to single
                            data = data.replace(/"/g, "'");

                            // replace p with br
                            data = data.replace(/<p[^>]*>/g, '').replace(/<\/p>/g, '<br>');

                            // replace div with br
                            data = data.replace(/<div[^>]*>/g, '').replace(/<\/div>/g, '<br>');

                            data = remove_tags(data);

                            //split at each new line
                            let splitData = data.split('<br>');

                            //remove empty string
                            splitData = splitData.filter(function (v) {
                                return v !== ''
                            });

                            data = '';
                            for (let i = 0; i < splitData.length; i++) {
                                //add escaped double quotes around each line
                                data += '\"' + splitData[i] + '\"';
                                //if its not the last line add CHAR(13)
                                if (i + 1 < splitData.length) {
                                    data += ', CHAR(10), ';
                                }
                            }

                            //Add concat function
                            data = 'CONCATENATE(' + data + ')';
                            return data;

                        }
                    }
                },
                customize: function (xlsx) {

                    var sSh = xlsx.xl['styles.xml'];

                    var styleSheet = sSh.childNodes[0];

                    let cellXfs = styleSheet.childNodes[5];

                    // Using this instead of "" (required for Excel 2007+, not for 2003)
                    var ns = "http://schemas.openxmlformats.org/spreadsheetml/2006/main";

                    // Create a custom style
                    var lastStyleNum = $('cellXfs xf', sSh).length - 1;
                    var wrappedTopIndex = lastStyleNum + 1;
                    var newStyle = document.createElementNS(ns, "xf");
                    // Customize style
                    newStyle.setAttribute("numFmtId", 0);
                    newStyle.setAttribute("fontId", 0);
                    newStyle.setAttribute("fillId", 0);
                    newStyle.setAttribute("borderId", 0);
                    newStyle.setAttribute("applyFont", 1);
                    newStyle.setAttribute("applyFill", 1);
                    newStyle.setAttribute("applyBorder", 1);
                    newStyle.setAttribute("xfId", 0);
                    // Alignment (optional)
                    var align = document.createElementNS(ns, "alignment");
                    align.setAttribute("vertical", "top");
                    align.setAttribute("wrapText", 1);
                    newStyle.appendChild(align);
                    // Append the style next to the other ones
                    cellXfs.appendChild(newStyle);


                    var sheet = xlsx.xl.worksheets['sheet1.xml'];

                    var firstExcelRow = 3;



                    table.rows({order: 'applied', search: 'applied'}).every(function (rowIdx, tableLoop, rowLoop) {

                        $(this).attr('ht', 60);
                        $(this).attr('customHeight', 1);

                        var node = this.node();

                        var num_colonne = $(node).find("td").length;

                        // the cell with biggest number of line inside it determine the height of entire row
                        var maxCountLinesRow = 1;

                        for (var indexCol = 1; indexCol <= num_colonne; indexCol++) {

                            var letterExcel = columnToLetter(indexCol);

                            $('c[r=' + letterExcel + (firstExcelRow + rowLoop) + ']', sheet).each(function (e) {


                                // how many lines are present in this cell?
                                var countLines = ($('is t', this).text().match(/\"/g) || []).length / 2;

                                if (countLines > maxCountLinesRow) {
                                    maxCountLinesRow = countLines;
                                }

                                if ($('is t', this).text()) {
                                    //wrap text top vertical top
                                    $(this).attr('s', wrappedTopIndex);

                                    //change the type to `str` which is a formula
                                    $(this).attr('t', 'str');
                                    //append the concat formula
                                    $(this).append('<f>' + $('is t', this).text() + '</f>');
                                    //remove the inlineStr
                                    $('is', this).remove();
                                }

                            });

                            $('row:nth-child(' + (firstExcelRow + rowLoop) + ')', sheet).attr('ht', maxCountLinesRow * 26);
                            $('row:nth-child(' + (firstExcelRow + rowLoop) + ')', sheet).attr('customHeight', 1);

                        }

                    });



                }

            }

        ],


    });

    /* /DataTable */

    // Спрашивать перед удалением
    $('.delete-object-btn').on('click', function () {
        return confirm("Вы уверены, что хотите удалить объект?");
    });

    $('.delete-supplier-btn').on('click', function () {
        return confirm("Вы уверены, что хотите удалить поставщика?\nВсе товары и контактные лица будут удалены!");
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

    $('.custom-file-input').on('change', function () {
        let files = $(this)[0].files;
        let name = '';
        for (var i = 0; i < files.length; i++) {
            name += '\"' + files[i].name + '\"' + (i != files.length - 1 ? ", " : "");
        }
        $(".custom-file-label").html(name);
    });



    // Очистка формы добавления продукта
    $('#resetSupplierFormBtn').on('click', function (ev) {
        ev.preventDefault()
        $(this).closest('form').find('input[type="text"], textarea').val('');
        $(this).closest('form').find('select').prop("selectedIndex", 0);
    });



});




