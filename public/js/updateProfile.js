$(document).ready(function () {
    initial();

    firstClick();

    function firstClick() {
        document
            .getElementById("changePassword")
            .addEventListener("click", function () {
                $("#alertBox").toggleClass("visible");
            });
    }

    function initial() {
        var oldtownship = document.getElementById("oldts").value;
        var selected = "";
        var checkerror = document.getElementById("error").value;
        console.log(checkerror);
        if (checkerror == 1) {
            $("#alertBox").addClass("visible");
        }
        var checkerror2 = document.getElementById("error2").value;
        if (checkerror2 == 1) {
            $("#alertBox").addClass("visible");
        }
        let state = document.getElementById("addressState").value;
        console.log(state);
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
        });
        var formdata = { data: state };
        $.ajax({
            type: "POST",
            url: "getTownship",
            data: formdata,
            success: (response) => {
                console.log(response);
                let townships = document.getElementsByClassName("townships");
                if (townships.length != 0) {
                    $(`.townships`).remove();
                }
                for (let i = 0; i < response.length; i++) {
                    selected = "";
                    if (response[i]["id"] == oldtownship) selected = "selected";
                    $("#addressTownship").append(
                        `<option class="text-dark townships" value="${response[i]["id"]}" ${selected}>${response[i]["township_name"]}</option>`
                    );
                }
            },
            error: (error) => {
                console.log(error);
            },
        });
    }

    document.getElementById("addressState").addEventListener("change", () => {
        initial();
    });
    // var FavJson = {};
    // $.ajax({
    //     type: "GET",
    //     url: "getfavtypes",
    //     success: function (data) {
    //         FavJson = JSON.stringify(data);
    //         console.log(FavJson);
    //         $("#favTypesInput").tagsinput({
    //             typeahead: {
    //                 source: function (query) {
    //                     return FavJson;
    //                 },
    //             },
    //         });
    //     },
    // });
    // document.getElementById("favTypesInput").addEventListener("change", () => {
    //     $("favTypesInput").tagsinput("items");
    // });

    var favTypes = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace("name"),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: {
            url: location.protocol + "//" + location.host + "/getfavtypes/",
            cache: false,
            filter: function (list) {
                return $.map(list, function (favourite_food) {
                    return { name: favourite_food };
                });
            },
        },
    });
    favTypes.initialize();

    $("#favTypesInput").tagsinput({
        typeaheadjs: {
            name: "favtype",
            displayKey: "name",
            valueKey: "name",
            source: favTypes.ttAdapter(),
        },
    });

    // elt.tagsinput({
    //     itemValue: "value",
    //     itemText: "text",
    //     typeaheadjs: {
    //         name: "favTypes",
    //         displayKey: "text",
    //         source: favTypes.ttAdapter(),
    //     },
    // });
});
