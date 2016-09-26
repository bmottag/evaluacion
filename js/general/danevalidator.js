/*************************************
 * Librería de Funciones JavaScript
 * @author Daniel M. Díaz
 * @since  Julio 28 / 2015
 *************************************/

/*window.onbeforeunload = function(event) {
    event.returnValue = '¿Esta seguro que quiere salir de aqui?';
};*/

//var base_url = "http://192.168.1.200/daneweb/ghumana/";  //Ruta base para ejecutar AJAX en CodeIgniter (PRUEBAS)
metaCollection = document.getElementsByTagName('meta'); 

for (i=0;i<metaCollection.length;i++) { 
    nameAttribute = metaCollection[i].name.search(/baseurl/);
    if (nameAttribute!= -1) { 
        var base_url = metaCollection[i].content;
    } 
}

$(function () {
    $(window).scroll(function () {
        if ($(this).scrollTop() > 400) {
            $('.scrollup').fadeIn();
        } else {
            $('.scrollup').fadeOut();
        }
    });

    $('.scrollup').click(function () {
        $("html, body").animate({scrollTop: 0}, 600);
        return false;
    });
    
    //********************************************************************************************
    //* 1) Establece el valor máximo de caracteres que pueden ir en una caja de texto.
    //********************************************************************************************
    $.fn.maxlength = function (expresion) {
        return this.keypress(function (event) {
            if ((event.which == 8) || (event.which == 0))
                return true;
            else if ($(this).val().length < expresion)
                return true;
            else
                return false;
        });
    };

    //*******************************************************************************************
    //* 2) Bloquea el ingreso de caracteres de texto en una caja de texto. Solo permite números
    //*******************************************************************************************
    $.fn.bloquearTexto = function () {
        return this.keypress(function (event) {
            if ((event.which == 8) || (event.which == 0) || (event.which == 45))
                return true;
            if ((event.which >= 48) && (event.which <= 57))
                return true;
            else
                return false;
        });
    };

    //******************************************************************************************
    //* 3) Bloquea el ingreso de caracteres numericos en una caja de texto. Solo permite letras
    //******************************************************************************************
    $.fn.bloquearNumeros = function () {
        return this.keypress(function (event) {
            if ((event.which < 48) || (event.which > 57))
                return true;
            else
                return false;
        });
    };

    //******************************************************************************************
    //* 4) Convierte el contenido de una caja de texto todo a mayusculas
    //******************************************************************************************
    $.fn.convertirMayuscula = function () {
        return this.blur(function (event) {
            $(this).val($(this).val().toUpperCase());
        });
    };

    //******************************************************************************************
    //* 5) Convierte el contenido de una caja de texto todo a minusculas
    //******************************************************************************************
    $.fn.convertirMinuscula = function () {
        return this.blur(function (event) {
            $(this).val($(this).val().toLowerCase());
        });
    };

    //******************************************************************************************
    //* 6) verificar que el contenido no sean solo espacios
    //******************************************************************************************
    $.fn.verificaEspacios = function () {
        return this.blur(function (event) {
            var ele = $(this).val();
            //alert ("aqui"+ele);
            var tama = ele.length;
            if ((vacio(ele) == false) && (tama > 0)) {
                alert("Introduzca un cadena de texto.")
                $(this).val("");
            }
        });
    };
    //******************************************************************************************
    //* 7) verificar que el contenido no sean solo espacios
    //******************************************************************************************
    $.fn.minlength = function (expresion) {
        return this.blur(function (event) {
            var ele = $(this).val();
            var tama = ele.length;
            if ((tama < expresion)) {
                alert("Debe ser m\u00ednimo de " + expresion + " digitos")
                $(this).val("");
            }
        });
    };

    //****************************************************************************
    //* Valida que el valor por defecto de un comboBox no se haya seleccionado 
    //****************************************************************************
    $.validator.addMethod("comboBox", function (value, element, param) {
        var idx = (param).toString();
        if ($(element).val() == idx)
            return false;
        else
            return true;
    }, "");


    //*****************************************************************************************
    //* Ejecuta una funcion ajax para actualizar un comboBox
    //*****************************************************************************************
    $.fn.cargarCombo = function (element, url) {
        return this.change(function (event) {

            $("#" + element + " option[value='-']").prop('selected', true)
            $.ajax({
                type: "POST",
                url: url,
                data: "id=" + $(this).val(),
                dataType: "html",
                cache: false,
                success: function (html) {
                    var target = "#" + element;
                    $(target).html("");
                    $(html).appendTo(target);
                },
                error: function (result) {
                    $("#" + element + " option[value='-']").attr("selected", "selected");
                }
            });
        });
    };

    //************************************************************************
    //* Configura y ajusta todos los calendarios de jQuery en idioma español
    //************************************************************************
    $.datepicker.regional['es'] = {closeText: 'Cerrar',
        currentText: 'Hoy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'S&aacute;b'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'S&aacute;'],
        weekHeader: 'Sem',
        dateFormat: 'dd/mm/yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: '',
        changeMonth: true,
        changeYear: true,
        yearRange: '1901:2100'
    };
    $.datepicker.setDefaults($.datepicker.regional['es']);

    //************************************************************************
    //* Valida que una fecha digitada sea valida, con formato dd/mm/yyy
    //************************************************************************
    jQuery.validator.addMethod("dateFormatValid", function (value, element) {
        var check = false;
        //var re = /^\d{1,2}\.\d{1,2}\.\d{4}$/;
        var re = /^\d{1,2}\/\d{1,2}\/\d{4}$/;
        if (re.test(value)) {
            var adata = value.split('/');
            var dd = parseInt(adata[0], 10);
            var mm = parseInt(adata[1], 10);
            var yyyy = parseInt(adata[2], 10);
            var xdata = new Date(yyyy, mm - 1, dd);
            if ((xdata.getFullYear() === yyyy) && (xdata.getMonth() === mm - 1) && (xdata.getDate() === dd)) {
                check = true;
            } else {
                check = false;
            }
        } else {
            check = false;
        }
        return this.optional(element) || check;
    });

    //****************************************************************************************************************
    //** Compara y valida que el valor de una caja de texto contra una expresion completa escrita en jQuery
    //****************************************************************************************************************
    $.validator.addMethod("expresion", function (value, element, param) {
        var comp = convertirExpresion(param);
        if (comp) {
            return false;
        } else {
            return true;
        }
    }, "");

    $.validator.addMethod("expresion2", function (value, element, param) {
        var comp = convertirExpresion(param);
        if (comp) {
            return false;
        } else {
            return true;
        }
    }, "");
    
    $.fn.validarCorreo = function () {
        // Expresion regular para validar el correo
        var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

        // Se utiliza la funcion test() nativa de JavaScript
        if (regex.test($(this).val().trim())) {
            return true;
        } else {
            return false;
        }
    };
    
    $.fn.soloTexto = function () {
        return this.keypress(function (event) {
            if ((event.which == 8) || (event.which == 0) || (event.which == 45) || (event.which == 189) || (event.which == 190))
                return true;
            if ((event.which >= 97) && (event.which <= 122))
                return true;
            if ((event.which >= 65) && (event.which <= 90))
                return true;
            else
                return false;
        });
    };
});//EOC


//*************************************************************************************************
//* Genera una direccion URL para paso de parametros por GET, para el envio de AJAX en JavaScript
//*************************************************************************************************
function generateGetURL(path, data) {
    var i = 0;
    var url = base_url + path;
    for (i = 0; i < data.length; i++) {
        if (isNaN(data[i]) && data[i].indexOf("/") > 0) {
            step1 = data[i].replace('/', '-');
            step2 = step1.replace('/', '-');
            data[i] = step2;
        } else if (isNaN(data[i]) && data[i].indexOf('%2F') > 0) {
            step1 = data[i].replace('%2F', '-');
            step2 = step1.replace('%2F', '-');
            data[i] = step2;
        } else if (data[i] == "") {
            data[i] = '-';
        }
        url = url + encodeURIComponent(data[i]) + "/";
    }
    url = url.substring(0, url.length - 1);
    return decodeURIComponent(url);
}

// Evalua una cadena de texto recibida como parametro y retorna un valor de verdadero o falso 
function convertirExpresion(cadena) {
    var result = false;
    if ((typeof cadena) == 'string')
        result = (eval(cadena)) ? true : false;
    return result;
}

/**
 * FunciÃ³n Especial
 * Esta funciÃ³n redirige al usuario a un mÃ³dulo para descarga de navegadores cuando se detecta que utiliza Internet Explorer
 * @author dmdiazf
 * @since  01/10/25
 */
function redirectBrowser() {
    var BrowserDetect = {
        init: function () {
            this.browser = this.searchString(this.dataBrowser) || "Other";
            this.version = this.searchVersion(navigator.userAgent) || this.searchVersion(navigator.appVersion) || "Unknown";
        },
        searchString: function (data) {
            for (var i = 0; i < data.length; i++) {
                var dataString = data[i].string;
                this.versionSearchString = data[i].subString;
                if (dataString.indexOf(data[i].subString) !== -1) {
                    return data[i].identity;
                }
            }
        },
        searchVersion: function (dataString) {
            var index = dataString.indexOf(this.versionSearchString);
            if (index === -1) {
                return;
            }
            var rv = dataString.indexOf("rv:");
            if (this.versionSearchString === "Trident" && rv !== -1) {
                return parseFloat(dataString.substring(rv + 3));
            } else {
                return parseFloat(dataString.substring(index + this.versionSearchString.length + 1));
            }
        },
        dataBrowser: [
            {string: navigator.userAgent, subString: "Edge", identity: "MS Edge"},
            {string: navigator.userAgent, subString: "Chrome", identity: "Chrome"},
            {string: navigator.userAgent, subString: "MSIE", identity: "Explorer"},
            {string: navigator.userAgent, subString: "Trident", identity: "Explorer"},
            {string: navigator.userAgent, subString: "Firefox", identity: "Firefox"},
            {string: navigator.userAgent, subString: "Safari", identity: "Safari"},
            {string: navigator.userAgent, subString: "Opera", identity: "Opera"}
        ]
    };
    BrowserDetect.init();
    if ((BrowserDetect.browser == 'Explorer') && (BrowserDetect.version < 9)) {
        var url = base_url + "ieredirect";
        $(location).attr("href", url);
    }
}

function serializarForm(id) {
    var cadena = $('#' + id).serialize();
    var temp = cadena.split('&');
    var temp2 = new Array();
    var data = new Array();
    for (i = 0; i < temp.length; i++) {
        temp2 = temp[i].split('=');
        if (isNaN(temp2[1]) && temp2[1].indexOf('%2F') > 0) {
            temp2[1] = formatearFecha(temp2[1]);
        }
        data.push(temp2[1]);
    }
    return data;
}

function serializarFormArray(id) {
    var cadena = $('#' + id).serialize();
    var temp = cadena.split('&');
    var temp2 = new Array();
    var data = new Array();
    for (i = 0; i < temp.length; i++) {
        temp2 = temp[i].split('=');
        if (isNaN(temp2[1]) && temp2[1].indexOf('%2F') > 0) {
            temp2[1] = formatearFecha(temp2[1]);
        }
        data.push(temp2[1]);
    }
    return data;
}

function resultadoValido(data) {
    if ((!/ERROR/.test(data)) && (!/Error/.test(data)) && (!/error/.test(data)) && (/-ok-/.test(data)))
        return true;
    else
        return false;
}

function validarHora(valorHora) {
    return (/^(([01][0-9])|(2[0123]))(:[0-5][0-9])(:[0-5][0-9])?$/.test(valorHora)) ? true: false;
}

//Validar del campo de formulario de URL
function validaURL(url) {
    //var regex = /^(ht|f)tps?:\/\/\w+([\.\-\w]+)?\.([a-z]{2,4}|travel)(:\d{2,5})?(\/.*)?$/i
    var regex = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
    return regex.test(url);
}

function formatearFecha(fecha) {
    if (isNaN(fecha) && fecha.indexOf('%2F') > 0) {
        var temp = fecha.split('%2F');
        return temp[2] + '-' + temp[1] + '-' + temp[0];
    } else if (isNaN(fecha) && fecha.indexOf('/') > 0) {
        var temp = fecha.split('/');
        return temp[2] + '-' + temp[1] + '-' + temp[0];
    } else if (isNaN(fecha) && fecha.indexOf('-') > 0) {
        var temp = fecha.split('-');
        return temp[2] + '/' + temp[1] + '/' + temp[0];
    }
}

function validarTextoCorreo(texto) {
    // Expresion regular para validar el correo
    var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

    // Se utiliza la funcion test() nativa de JavaScript
    if (regex.test(texto.trim())) {
        return true;
    } else {
        return false;
    }
}