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
                console.log(xml)
                images = xml.getElementsByTagName("media:thumbnail");
                rss = $(xml);
                source = rss.find("channel").find("title").first().text()
                source_link = rss.find("channel").find("link").first().text()
                rss.find("item").each(function(i) {
                    item = $(this);
                    title = "";
                    date = "";
                    link = "";
                    description = "";
                    image = "";
                    if (item.find("title") != undefined) {
                        title = item.find("title").text();
                    }
                    if (item.find("pubDate") != undefined) {
                        date = item.find("pubDate").text();
                    }
                    if (item.find("description") != undefined) {
                        description = item.find("description").text();
                    }
                    if (item.find("link") != undefined) {
                        link = item.find("link").text();
                    }
                    if (images[i] != undefined) {
                        image = images[i].getAttribute("url")
                    } else {
                        image = "none"
                    }
                    article = {
                        title: "<a href=" + source_link + ">" + source + "</a>: " + title,
                        date: date,
                        link: link,
                        description: description,
                        image: image
                    };
                    feed.push(article);
                    return i < 10;
                });
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
        if (article.image != "none") {
            console.log(article.image)
            body += "<img height=250rem width=400rem src=" + article.image + "></img><br>";
        }
        body += "<p>" + article.date + " <br> " + article.description + " <br> <a href = " + article.link + " > Link </a><br></p> <br> "
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