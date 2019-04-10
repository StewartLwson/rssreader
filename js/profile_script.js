$(document).ready(function() {

    $.getJSON({
        url: "http://localhost/rssreader/feed.php",
        success: function(result) {
            if (result.length > 0) {
                result.forEach(function(entry) {
                    num = entry["id"];
                    url = entry["rss_link"];
                    $("#feed_list").append("<span id=" + num + " class='source'>" + url + "</span><br>");
                });
            }
        }
    });

    to_remove = []

    $(document).on("click", ".source", function() {
        id = $(this).attr("id");
        index = to_remove.indexOf(id)
        if (index >= 0) {
            to_remove.pop(index)
            $(this).css("background-color", "white");
        } else {
            to_remove.push(id);
            $(this).css("background-color", "yellow");
        }
        console.log(to_remove)
    })

    $("#remove_source").click(function() {
        for (var i = 0; i < to_remove.length; i++) {
            console.log("http://localhost/rssreader/feed.php?id=" + to_remove[i])
            $.ajax({
                url: "http://localhost/rssreader/feed.php?id=" + to_remove[i],
                type: "DELETE",
                error: function(e) {
                    console.log(e);
                }
            })

        }
    })

    $("#add_source").click(function() {
        $.ajax({
            url: "http://localhost/rssreader/feed.php?link=" + $("#link").val(),
            type: "POST",
            success: function() {
                console.log("success")
            },
            error: function(e) {
                console.log(e);
            }
        })
    })
});