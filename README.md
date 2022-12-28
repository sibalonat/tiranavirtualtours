
## About this Project

This project was commisioned and planned to start in July, and started around September. It has been built with Laravel in the Backend and Vue in the Frontend. 

### Details about how it works
This site has been build to be a web application with a dedicated dashboard. The separation is simple there is a list of tours. Each Tour has different stations that are mapped through an online map that displays where are you are when you open the page and which are the destinations(stations to visit). When you click to one of the Stations, the route becomes visible, it gets drawn in the map and displays how long it takes to get there. The default has been choosen an open source one -  it often displays that the plugin is not for production but i didnt have much time to configure mapbox or another. After you come to the vicinity of the station location, the link becomes tapable or clickable and you can open to see the content inside. 
The page of each station is separated into different sections. It's the text - with description and author bio with the thumbnail picture(initialone when the page loads - in the same space will be placed other content such as the audio player). Then are four or three buttons(depending if there is AR for this station). The buttons that are not for the Augmented Reality, are language change for the text and audio content, the audio player display, the gallery display, and the video display. Due to using Vue3 for this project each of these content are loaded in one component and rendered only when you tap the neccesary button. If the content is AR, it takes you to another page, and it either scans for displaying the 3D content or displays the content based on the fact that the condition of location vicinity has been meet.  

It is also an Mobile Application with the use of PWA. It will be on the shelves of the ios and android stores where can be downloaded and installed. 

## Stacks, libraries and lots of appreaciation to the creators of the plugins that i mention below
Main: {
    Backend: {
        name: Laravel,
        plugins: {
            [momentum-modal, media library - spatie]
        }
    },
    Frontend: {
        js: {
            name: Vue,
            plugins: [p5, trois(wrapper for threejs), vue-filepond, momentum-modal, vueuse, animejs, vue leaflet, pinia, swiper, v3d-player, leaflet-routing-machine, howler]
        },
        css: ['Tailwind', 'heroicons']
    }
},



## Security Vulnerabilities

If you discover a security vulnerability within this app, or suggestion ping at [sibalonat@gmail.com](mailto:sibalonat@gmail.com). I will make my best effort to address every suggestion or issues you face.

## License

This App is still in development and will be presented by the end of February [MIT license](https://opensource.org/licenses/MIT).
