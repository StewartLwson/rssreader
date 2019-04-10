$(document).ready(function() {

    function makeRequest(link) {

        if (window.XMLHttpRequest) {
            req = new XMLHttpRequest();
        } else if (window.ActiveXObject) {
            req = new ActiveXObject("Msxml2.XMLHTTP");
        } else {
            // Ajax not supported
            return;
        }

        req.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var xml = this.responseXML;
                console.log(xml);

                var titles = xml.getElementsByTagName("title");
                var descriptions = xml.getElementsByTagName("description");
                var dates = xml.getElementsByTagName("pubDate");
                var images = xml.getElementsByTagName("media:thumbnail");

                console.log(titles)

                feed = []

                for (var i = 1; i < titles.length; i++) {
                    title = ""
                    date = ""
                    description = ""
                    image = ""
                    if (titles[i] != undefined) {
                        title = titles[i].innerHTML
                    }
                    if (dates[i] != undefined) {
                        date = dates[i].innerHTML
                    }
                    if (descriptions[i] != undefined) {
                        description = descriptions[i].innerHTML
                    }
                    if (images[i] != undefined) {
                        image = images[i - 1].getAttribute("url")
                    }
                    article = {
                        title: title,
                        date: date,
                        description: description,
                        image: image
                    }
                    feed.push(article)
                }

                feed.sort(function(a, b) {
                    date1 = ""
                    date2 = ""
                    for (var i = 5; i <= 15; i++) {
                        date1 += b.date[i]
                        date2 += a.date[i]
                    }
                    return Date(date1) - Date(date2);
                })

                for (var i = 0; i < feed.length; i++) {
                    title = "<h1>" + feed[i].title + "</h1><br>"
                    body = "<img src=" + feed[i].image + "/><br><p>" + feed[i].date + "<br>" + feed[i].description + "</p><br>"
                    document.getElementById("feed").innerHTML += title + body

                }
            }
        };

        req.open("GET", "https://cors-anywhere.herokuapp.com/" + link, true);
        req.send();

    }

    $.getJSON({
        url: "http://localhost/rssreader/feed.php",
        success: function(result) {
            result.forEach(function(entry) {
                url = entry["rss_link"];
                makeRequest(url);
            });
        }
    });

    $("#newfeed").click(function() {
        $.ajax({
            url: "http://localhost/rssreader/feed.php?link=" + $("#link").val(),
            type: "POST",
            error: function(e) {
                console.log(e);
            }
        })
    })
});