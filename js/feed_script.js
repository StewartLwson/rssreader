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

                var everything = xml.getElementsByTagName("*");
                var titles = xml.getElementsByTagName("title");
                var descriptions = xml.getElementsByTagName("description");
                var dates = xml.getElementsByTagName("pubDate");
                var images = xml.getElementsByTagName("media:thumbnail");

                console.log(xml)

                feed = []

                for (var i = 0; i < titles.length; i++) {
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

                for (var i = 0; i < feed.length; i++) {
                    title = "<h5>" + feed[i].title + "</h5><br>"
                    console.log()
                    body = "<img height=250rem width=400rem src=" + feed[i].image + "></img><p><br>" + feed[i].date + "<br>" + feed[i].description + "</p><br>"
                    document.getElementById("feed").innerHTML += title + body
                }
            }
        };

        cors = "https://cors-anywhere.herokuapp.com/"
        req.open("GET", cors + link, true);
        req.send();

    }

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