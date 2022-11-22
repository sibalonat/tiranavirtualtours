<script setup>
import * as L from 'leaflet';
import { OSRMv1, Control as RoutingControl } from '@fleetbase/leaflet-routing-machine';
import { onMounted } from 'vue';

const props = defineProps({
    latlng: Object,
    location: Object,
    map: Object
})

onMounted(() => {
    // const map = new L.Map();
    const serviceUrl = 'http://router.project-osrm.org';
    const router = new OSRMv1({ serviceUrl, profile: 'driving' });
    console.log(props);
    // const routingControl = new RoutingControl({ waypoints: [...], router }).addTo(leafletMap);
})
</script>

<template>
    <div>this is it</div>

</template>
