/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/*
function listenForChanges() {
    Echo.channel('posts')
        .listen('PostPublished', post => {
            if (!('Notification' in window)) {
                alert('Web Notification is not supported');
                return;
            }

            Notification.requestPermission(permission => {
                let notification = new Notification('New post alert!', {
                    body: post.title, // content for the alert
                    icon: "https://pusher.com/static_logos/320x320.png" // optional image url
                });

                // link to page on clicking the notification
                notification.onclick = () => {
                    window.open(window.location.href);
                };
            });
        })
}*/

$(document).ready(function(){

    if(window.Laravel.user) {
        // Let's check if the browser supports notifications
        if (!("Notification" in window)) {
            console.log('aw shucks, you don‘t have notifications…')
        }

        // Let's check whether notification permissions have already been granted
        else if (Notification.permission === "granted") {
        }

        // Otherwise, we need to ask the user for permission
        else if (Notification.permission !== "denied") {
            Notification.requestPermission(function (permission) {
                // If the user accepts, let's create a notification
                if (permission === "granted") {
                    var notification = new Notification('CEB Outage Watcher', {
                        body: "You'll be notified of new planned outages in your location watch list"
                    });
                }
            });
        }
    }

});

window.Echo.private('user.' + window.Laravel.user)
    .listen('UserLocationMatch', (e) => {
        console.log(e);

        if (! ('Notification' in window)) {
            alert('Web Notification is not supported');
            return;
        }

        Notification.requestPermission( permission => {
            let notification = new Notification('CEB outage alert!', {
                body: 'Planned outage in ' + e.outage.locality, // content for the alert
                badge: "/img/power.png", // optional image url
                requireInteraction: true,
            });

            // link to page on clicking the notification
            notification.onclick = () => {
                window.open(window.location.href);
            };
        });
    });