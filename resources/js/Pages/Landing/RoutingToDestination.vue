<script setup>
import * as L from 'leaflet';
import { OSRMv1, Control as RoutingControl } from '@fleetbase/leaflet-routing-machine';
import { getCurrentInstance, onMounted, reactive, ref, watchEffect } from 'vue';

const props = defineProps({
    latlng: Object,
    location: Object,
    map: Object
})

let dt = ref(null)

const serviceUrl = 'https://router.project-osrm.org/route/v1';
const router = new OSRMv1({ serviceUrl, profile: 'driving' });
let routingControl = ref(null);
// let routingControl = reactive(new RoutingControl({ waypoints: [], router }));

onMounted(() => {
    // const map = new L.Map('myMap');
    // const serviceUrl = 'https://router.project-osrm.org/route/v1';
    // const router = new OSRMv1({ serviceUrl, profile: 'driving' });
    // console.log(props);
    // console.log(router);
    // console.log(dt.value.$forceReload());
    const instance = getCurrentInstance();
    // instance.proxy.forceUpdate()
    instance.proxy.$forceUpdate()
    // console.log(instance.proxy.$forckn b\eUpdate());

    // routingControl
    // routingControl = null
    routingControl.value = new RoutingControl({ waypoints: [props.location, props.latlng], router })
    .addTo(props.map.leafletObject);

    console.log(routingControl.value);
})

watchEffect(() => {
    props.latlng
    props.location
    props.map
    console.log(props.map);
    console.log(props.latlng);

})
</script>

<template>
    <div ref="dt"></div>
</template>
