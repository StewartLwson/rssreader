$(document).ready(function() {

    function makeRequest(link) {

        feed = []

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

                var items = xml.getElementsByTagName("item");
                var titles = xml.getElementsByTagName("title");
                var descriptions = xml.getElementsByTagName("description");
                var dates = xml.getElementsByTagName("pubDate");
                var images = xml.getElementsByTagName("media:thumbnail");

                for (var i = 1; i < 10; i++) {
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
                        image = images[i].getAttribute("url")
                    }
                    article = {
                        title: title,
                        date: date,
                        description: description,
                        image: image
                    }
                    feed.push(article)

                }
            }
        };

        cors = "https://cors-anywhere.herokuapp.com/"
        req.open("GET", cors + link, true);
        req.send();

    }

    function addToFeed(article) {
        console.log(article)
        title = "<h5>" + article.title + "</h5><br>"
        body = ""
        if (article.image != "") {
            body += "<img height=250rem width=400rem src=" + article.image + "></img>";
        }
        body += "<p><br>" + article.date + "<br>" + article.description + "</p><br>"
        document.getElementById("feed").innerHTML += title + body
    }

    function applyFeed() {
        document.getElementById("feed").innerHTML = ""
        feed.sort(function(a, b) {
            return new Date(b.date) - new Date(a.date);
        });
        for (var i = 0; i < feed.length; i++) {
            addToFeed(feed[i])
        }
    }

    $("#get_feed").click(function() {
        applyFeed()
    });

    $.getJSON({
        url: "http://localhost/rssreader/feed.php",
        success: function(result) {
            if (result.length > 0) {
                result.forEach(function(entry) {
                    url = entry["rss_link"];
                    makeRequest(url);
                });
            }
        }
    });
});