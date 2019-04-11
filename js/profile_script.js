// script that runs on profile page
$(document).ready(function() { // run when document is fully loaded

    $.getJSON({ // gets json object from rss api
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

    to_remove = [] // array of sources user wants to remove

    $(document).on("click", ".source", function() { // boldens the source user wants to remove
        id = $(this).attr("id");
        index = to_remove.indexOf(id)
        if (index >= 0) { // checks if item already exists in list
            to_remove.pop(index)
            $(this).css("font-weight", "");
        } else {
            to_remove.push(id);
            $(this).css("font-weight", "bold");
        }
    })

    $("#remove_source").click(function() { // iterates through removal list
        for (var i = 0; i < to_remove.length; i++) {
            $.ajax({
                url: "http://localhost/rssreader/feed.php?id=" + to_remove[i], // makes request to remove item
                type: "DELETE",
                error: function(e) {}
            })

        }
    })

    $("#add_source").click(function() { // adds source
        $.ajax({
            url: "http://localhost/rssreader/feed.php?link=" + $("#link").val(), // makes request to add source
            type: "POST",
            success: function() {},
            error: function(e) {}
        })
    })
});