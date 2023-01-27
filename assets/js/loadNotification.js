setInterval(function() {
    $.ajax({
        url: 'modal/getLabel.php',
        dataType: 'json',
        success: function(data) {
            // console.log(data);
            var reslt = data;
            $('#aklabel').html(reslt.dataun);
            $('#labelhdr').html(reslt.dataun);
        }
    });

    $.ajax({
        url: 'modal/getCountPts.php',
        dataType: 'json',
        success: function(data) {
            // console.log(data);
            var cnt = document.getElementById("x");
            var reslt = data;
            // $('#countID').html(reslt.countID);
            if (reslt.countID >= '1') {
                cnt.innerHTML =
                    '<span class="label label-warning label-xs float-right">' +
                    reslt
                    .countID +
                    '</span>';
            }
        }
    });
}, 1000);