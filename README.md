
## About this Project

This project was commisioned and planned to start in July, and started around September. It has been built with Laravel in the Backend and Vue in the Frontend. 

### Details about how it works
This site has been build to be a web application with a dedicated dashboard. The separation is simple there is a list of tours. Each Tour has different stations that are mapped through an online map that displays where are you are and which are the destinations. When you click to one of the Stations, the route becomes, visible, its been drawn in the map and displays how long it takes to get there. The default has been choosen an open source one -  it often displays that the plugin is not for production but i didnt have much time to configure mapbox or another. After you come to the vicinity of the station location, the link becomes tapable or clickable and you can open to see the content inside. 
The page of each station is separated into different section. Its the text, the thumbnail picture(initia when the page loads), four or three depending if there is AR for this station. The button that are not AR, are language change for the text and audio content, the audio player display, the gallery display, and the video display. Due to using Vue3 for this project each of the are loaded in one component and rendered only when you tap the neccesary button. If the content is AR, it takes you to another page, and it either scans for displaying the 3D content or displays the content based on the fact that the condition of location vicinity has been meet.  

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
            plugins: [p5, trois(wrapper for threejs), vue-filepond, vueuse, animejs, vue leaflet, pinia, swiper, v3d-player, leaflet-routing-machine, howler]
        },
        css: ['Tailwind', 'heroicons']
    }
},



## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

This App is still in development and will be presented by the end of February [MIT license](https://opensource.org/licenses/MIT).
