$(function(){

    $("body").on("click", "input.star", function(e){
        var $star = $(this);
        var rating = $star.val(),
            postId = $star.data("post");

        $.ajax({
            url: '/rate/post',
            dataType: 'json',
            method: "POST",
            data: {
                postId: postId,
                rating: rating
            },
            success: function(data) {
                if(data.success == true) {
                    var starRate = data.rating.totalRating;
                    var checked = $("input.star-"+starRate);
                    checked.attr("checked", "checked");
                    $("input.star").each(function(){
                        var $input = $(this);
                        $input.attr("disabled", "disabled");
                    });
                } else if(data.success == false) {
                    console.log(data.errors);
                }
            }

        });
    });

});