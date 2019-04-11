// script that runs on the feed page
$(document).ready(function() { // run when document is fully loaded

    function makeRequest(link) { // makes request to rss source link

        feed = [] // global feed which will contain all articles gathered from sources

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
                var xml = this.responseXML; // xml represenetation of rss
                images = xml.getElementsByTagName("media:thumbnail"); // thumbnail must be retrieved from raw xml
                rss = $(xml); // converts to rss xml jquery object
                source = rss.find("channel").find("title").first().text() // finds name of rss channel
                source_link = rss.find("channel").find("link").first().text() // finds link to source
                rss.find("item").each(function(i) { // for each rss item in source's feed
                    item = $(this); // item in feed
                    title = "";
                    date = "";
                    link = "";
                    description = "";
                    image = "";
                    if (item.find("title") != undefined) {
                        title = item.find("title").text(); // sets title (if exists)
                    }
                    if (item.find("pubDate") != undefined) {
                        date = item.find("pubDate").text(); // sets publication date (if exists)
                    }
                    if (item.find("description") != undefined) {
                        description = item.find("description").text(); // sets description (if exists)
                    }
                    if (item.find("link") != undefined) {
                        link = item.find("link").text(); // sets link to source (if exists)
                    }
                    if (images[i] != undefined) {
                        image = images[i].getAttribute("url") // sets thumbnail url (if exists)
                    } else {
                        image = "none" // set to none of no thumbnail exists
                    }
                    article = { // models article which will be processed into html for the feed
                        title: "<a href=" + source_link + ">" + source + "</a>: " + title,
                        date: date,
                        link: link,
                        description: description,
                        image: image
                    };
                    feed.push(article); // pushes article to global feed
                    return i < 10; // repeats until 10 articles are added
                });
            }
        };

        cors = "https://cors-anywhere.herokuapp.com/" // proxy that bypasses CORS
        req.open("GET", cors + link, true); // gets rss xml from CORS proxy prepended to source link
        req.send(); // sends request, therefore running above function

    }

    function addToFeed(article) { // processes article with html to be added to frontend feed
        title = "<h5>" + article.title + "</h5><br>"
        body = ""
        if (article.image != "none") {
            body += "<img height=250rem width=400rem src=" + article.image + "></img><br>";
        }
        body += "<p>" + article.date + " <br> " + article.description + " <br> <a href = " + article.link + " > Link </a><br></p> <br> "
        document.getElementById("feed").innerHTML += title + body
    }

    function applyFeed() { // runs the feed through processor
        document.getElementById("feed").innerHTML = "" // clears feed
        feed.sort(function(a, b) { // sorts all articles contained in feed by most recent
            return new Date(b.date) - new Date(a.date);
        });
        for (var i = 0; i < feed.length; i++) {
            addToFeed(feed[i])
        }
    }

    $("#get_feed").click(function() { // gets feed when button is clicked
        // this is used as the feed will not be immediately ready for the user
        applyFeed()
    });

    $.getJSON({ // gets json object from rss api
        url: "http://localhost/rssreader/feed.php",
        success: function(result) {
            if (result.length > 0) { // if articles exist
                $("#get_feed").attr("disabled", false)
                result.forEach(function(entry) {
                    url = entry["rss_link"];
                    makeRequest(url);
                });
            } else { // if there are no articles, display message to user
                document.getElementById("feed").innerHTML = "<h5>Your feed is empty.</h5><br><p>Please come back later to see if there have been any updates or add a new source to your feed.</p>"
                $("#get_feed").attr("disabled", true)
            }
        }
    });
});