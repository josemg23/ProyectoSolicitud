
// var audio = document.getElementById('sound_lyon');
// audio.play();
var promise = document.getElementById('sound_lyon').play();
if (promise !== undefined) {
    promise.then(_ => {
        // Autoplay started!
    }).catch(error => {
        // Autoplay was prevented.
        // Show a "Play" button so that user can start playback.
    });
}

$(window).on('load', function () { // makes sure the whole site is loaded

    $('#status').delay(800).fadeOut(); // will first fade out the loading animation
    $('#preloader').delay(800).fadeOut('slow'); // will fade out the white DIV that covers the website.
    // var audio = document.getElementById('sound_lyon');
    var audio = document.getElementById('sound_lyon');


    setTimeout(function () { audio.pause() }, 800);
})


$(function () {
    openMenuMobile();
    openModal();
});


var sendForm = function () {
    $("#contact_form").submit(function (e) {
        if (!(validationsForms(["#nombre_contact", "#apellidos_contact", "#telefono_contact", "#email_contact", "#mensaje_contact"], [2, 2, 5, 5, 5]))) {
            e.preventDefault();
        } else {
            $("#modal_message").addClass("visible"); // para mostrar el modal
            e.preventDefault();
        }
    });
}

var validationsForms = function (arrayFields, arrayFieldsSize) {
    var inputIds = arrayFields;
    var inputSize = arrayFieldsSize;
    var flagInput = true, indexInput = [];
    var flagResult = true;

    for (var i = 0; i < inputIds.length; i++) {
        $(inputIds[i]).removeClass("required");
        flagInput = $(inputIds[i]).val().length >= inputSize[i]
        flagResult = flagResult && flagInput;
        if (flagInput == false) {
            indexInput.push(inputIds[i]);
        }
    }
    if (flagResult) {
        return true;
    } else {
        for (var i = 0; i < indexInput.length; i++) {
            $(indexInput[i]).addClass("required");
        }
        return false;
    }
}


openMenuMobile = function () {
    $(".open_menu_mobile").click(function () {
        $(".menu_mobile").addClass("active");
    });


    $(".menu_mobile ul li a, .close_menu_mobile").click(function () {
        $(".menu_mobile").removeClass("active");
    });

}


var openModal = function () {

    var titles = ["Vigilancia Privada", "Resguardo Personal y Residecial", "Estudios de Seguridad", "Seguridad Canina", "Vigilancia de Eventos Sociales", "Instrucción y Capacitación en Seguridad"];

    var contents = ["Leones de oro es una empresa peruana, capacitada en brindar seguridad a instituciones públicas, con una amplia experiencia en el campo, contando con personal altamente capacitado, y respondiendo según la necesidad del servicio. El personal se encuentra capacitado en manejo de multitudes, control de vehículos, manejo de pecosas tanto de salida e ingreso de materiales, papeletas de salida, etc. y estos se registran en el cuaderno de control.", "Servicio de resguardo, brindamos personal con entrenamiento especial y preventivo, para reaccionar en situaciones extremas con firmeza y seguridad. El servicio es prestado por un guardaespalda armado y dotados de equipos de seguridad según requerimientos del cliente.", "Según la necesidad del servicio, leones de oro hace estudios de seguridad para implementar medios de protección y así poder brindar el más óptimo servicio de seguridad ya sea a instituciones públicas o privadas, o servicios especiales. De esta manera también se prevé el cuidado físico de su personal a cargo de cada servicio.", "Leones de oro, presta a sus clientes el servicio de seguridad canina, según el tipo de servicio, y están entrenados para responder y repeler cualquier tipo de ataque delincuencial.", "Leones de oro brinda servicio de seguridad para eventos especiales, y según sus clientes lo requieran, para que de esta manera todo salga sin ninguna complicación en lo que respecta a seguridad.", "Leones de oro brinda a su vez a sus clientes y al público en general capacitación e instrucción en seguridad, para que puedan estar capacitados en seguridad, según reglamento SUCAMEC con instructores reconocidos y capacitados por SUCAMEC"]

    $(".button_see").click(function () {
        var current_service = $(this).data("service");
        $("#title_service").text(titles[current_service]);
        $("#content_service").text(contents[current_service]);
        $("#modal_service").addClass("visible");
    });

    $(".close_modal").click(function () {
        $("#modal_service, #modal_message").removeClass("visible");
    });

}


if ($(window).width() >= 480) {
    var $body = $('html, body'),
        actualSection = 0,
        speed = 500,
        totalSections = 5,
        isScrolling = false,
        scrollingTimer,
        clicking = false,
        friction = 200,
        startY;

    $('body').swipe({
        swipe: function (event, direction) {
            if (direction == 'up') {
                moveScroll('down');

            } else if (direction == 'down') {
                moveScroll('up');
            }
        }
    });
    $('body, a, iframe').on('touchmove', function (e) {
        e.stopPropagation();
        e.preventDefault();
    });
    $('a, iframe').on('mouseenter', function (e) {
        e.stopPropagation();
        e.preventDefault();
    });
    $.browserSwipe({
        up: function () {
            moveScroll('up');
        },
        down: function () {
            moveScroll('down');
        }
    });

    // window resize
    var resizeTimeout;
    $(window).on('resize', function () {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function () {
            moveScroll();
        }, 200);
    });

    var moveScroll = function (dir) {


        if ($body.is(':animated') == false) {

            isScrolling = true;
            clearTimeout(scrollingTimer);

            if (dir == 'up') {
                actualSection = actualSection <= 0 ? 0 : actualSection - 1;
            } else if (dir == 'down') {
                actualSection = actualSection >= totalSections - 1 ? totalSections - 1 : actualSection + 1;
            }

            if (actualSection == 0 || actualSection == 2) {
                $(".controls").addClass("dark")
            } else {
                $(".controls").removeClass("dark")
            }


            $("#controls .button").removeClass("current");
            $("#controls .button").eq(actualSection).addClass("current");

            $("header, .about_section, .services_section, .clients_section, .contact_section").addClass("showing");
            if (actualSection == 0) {
                $("header").removeClass("showing");
            } else if (actualSection == 1) {
                $(".about_section").removeClass("showing");
            } else if (actualSection == 2) {
                $(".services_section").removeClass("showing");
            } else if (actualSection == 3) {
                $(".clients_section").removeClass("showing");
            } else if (actualSection == 4) {
                $(".contact_section").removeClass("showing");
            }



            $('#scroll').css({ transform: 'translateY(-' + actualSection * $(window).height() + 'px)' }, speed);

            scrollingTimer = setTimeout(function () {
                isScrolling = false;
                clicking = false;
            }, speed + 20);
        }
    }


    $(function () {
        getIndex();
        btnContact();
    });


    var btnContact = function () {
        $(".btn_contact").click(function () {
            $("#modal_service").removeClass("visible");
            $("#controls .button:last-child").click();
        });

        $(".header_menu ul li").click(function () {
            var index_item = parseInt($(this).data("index"));
            $("#controls .button").eq(index_item).click();
        });

    }

    var getIndex = function () {
        $("#controls .button").click(function () {
            var currentIndex = $(this).index();
            $('#scroll').css({ transform: 'translateY(-' + currentIndex * $(window).height() + 'px)' }, speed);
            $("#controls .button").removeClass("current");
            $("#controls .button").eq(currentIndex).addClass("current");
            $("header, .about_section, .services_section, .clients_section, .contact_section").addClass("showing");

            if (currentIndex == 0) {
                $("header").removeClass("showing");
            } else if (currentIndex == 1) {
                $(".about_section").removeClass("showing");
            } else if (currentIndex == 2) {
                $(".services_section").removeClass("showing");
            } else if (currentIndex == 3) {
                $(".clients_section").removeClass("showing");
            } else if (currentIndex == 4) {
                $(".contact_section").removeClass("showing");
            }
        });
    }

} else {
    $(function () {
        btnContact();
    });

    var btnContact = function () {
        $(".btn_contact").click(function () {
            $("#modal_service").removeClass("visible");
        });
    }

}
