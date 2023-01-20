$(document).ready(function () {
    $("input[name=search]").on("keyup", function () {
        var searchTerm = $(this).val().toLowerCase();
        $("tbody tr").each(function () {
            var lineStr = $(this).text().toLowerCase();
            if (lineStr.indexOf(searchTerm) == -1) {
                $(this).hide();
            } else {
                $(this).show();
            }
        });
    });
});

(function ($) {
    $.fn.inputFilter = function (inputFilter) {
        return this.on(
            "input keydown keyup mousedown mouseup select contextmenu drop",
            function () {
                if (inputFilter(this.value)) {
                    this.oldValue = this.value;
                    this.oldSelectionStart = this.selectionStart;
                    this.oldSelectionEnd = this.selectionEnd;
                } else if (this.hasOwnProperty("oldValue")) {
                    this.value = this.oldValue;
                    this.setSelectionRange(
                        this.oldSelectionStart,
                        this.oldSelectionEnd
                    );
                } else {
                    this.value = "";
                }
            }
        );
    };
})(jQuery);

$(".number-input").inputFilter(function (value) {
    return /^-?\d*$/.test(value);
});

$(document).on("input propertychange paste", ".input-notzero", function (e) {
    var val = $(this).val();
    var reg = /^0/gi;
    if (val.match(reg)) {
        $(this).val(val.replace(reg, ""));
    }
});

$(function () {
    $("form[name='create_form']").validate({
        rules: {
            nama_kategori: "required",
        },
        messages: {
            nama_kategori: "Nama Kategori tidak boleh kosong",
        },
        errorPlacement: function (error, element) {
            var name = element.attr("name");
            $("#nama_kategori_error").html(error);
        },
        submitHandler: function (form) {
            form.submit();
        },
    });
});

var validator = $("form[name='update_form']").validate({
    rules: {
        nama_kategori: "required",
    },
    messages: {
        nama_kategori: "Nama Kategori tidak boleh kosong",
    },
    errorPlacement: function (error, element) {
        var name = element.attr("name");
        $("#nama_kategori_error").html(error);
    },
    submitHandler: function (form) {
        form.submit();
    },
});

$(".dropdown-search").on("hide.bs.dropdown", function () {
    $("tbody tr").show();
    $("input[name=search]").val("");
});
