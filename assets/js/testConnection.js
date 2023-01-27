

function makeid(length) {
    var result = '';
    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() *
            charactersLength));
    }
    return result;
}

setInterval(function () {

    $.ajax({
        url: "https://jsonplaceholder.typicode.com/todos/1",
        method: "get",
        success: function (data) {
            kondisi = 0;
            if (data != '') { kondisi = 1 }
            if (kondisi == 1) {
                var startime = new Date().getTime();
                var img = new Image();
                img.src = "https://static.vecteezy.com/system/resources/previews/001/191/174/non_2x/flower-floral-png.png?version=" + makeid(3);
                img.onload = function () {
                    var loadtime = new Date().getTime() - startime;
                    checkConnection(loadtime);
                }

                // console.log("online");
            }
        }, error: function (xhr, status, error) {
            var x = document.getElementById("connection");
            //var z = document.getElementById("connection2");

            x.innerHTML = "<label class='label label-secondary mr-auto' style='width:32px;height:32px;float:left;'><p id='val_con' style='display:none;'>0</p></label>";
            //z.innerHTML = "<label class='label label-secondary mr-auto' style='width:32px;height:32px;float:left;'><p id='val_con2' style='display:none;'>0</p></label>";
        }


    });




}, 5000);


function checkConnection(millisecond) {
    var y = window.navigator.onLine;
    var x = document.getElementById("connection");
    //var z = document.getElementById("connection2");
    if (millisecond > 2000) {

        x.innerHTML = "<span class='label label-danger float-right'><p id='val_con' style='display:none'>0</p></span>";
        //z.innerHTML = "<span class='label label-danger mr-auto text-center' style='width:32px;height:32px;float:left;'><p id='val_con2' style='display:none'>0</p></label>";
        // console.log(millisecond);
        if (y) {
            console.log("Online, millisecond:" + millisecond + "ms");
        }
    } else if (millisecond > 1700) {
        // console.log(millisecond);
        x.innerHTML = "<span class='label label-warning float-right'><p id='val_con' style='display:none'>0</p></span>";
        //z.innerHTML = "<label class='label label-warning mr-auto text-center' style='width:32px;height:32px;float:left;'><p id='val_con2' style='display:none'>0</p></label>";
        if (y) {
            console.log("Online, millisecond:" + millisecond + "ms");
        }
    } else if (millisecond > 1300) {
        // console.log(millisecond);
        x.innerHTML = "<span class='label label-info float-right'><p id='val_con' style='display:none'>1</p></span>";
        //z.innerHTML = "<label class='label label-info mr-auto text-center' style='width:32px;height:32px;float:left;'><p id='val_con2' style='display:none'>1</p></label>";
        if (y) {
            console.log("Online, millisecond:" + millisecond + "ms");
        }
    } else {
        x.innerHTML = "<span class='label label-primary float-right'><p id='val_con' style='display:none'>1</p></span>";
        //z.innerHTML = "<label class='label label-primary mr-auto text-center' style='width:32px;height:32px;float:left;'><p id='val_con2' style='display:none'>1</p></label>";
        // console.log(millisecond);
        if (y) {
            console.log("Online, millisecond:" + millisecond + "ms");
        }
    }
}