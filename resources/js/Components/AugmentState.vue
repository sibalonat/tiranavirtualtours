<script setup>
import { onBeforeMount, onMounted, onUnmounted, ref, watchEffect } from '@vue/runtime-core';

import {
    AmbientLight,
    Camera,
    DirectionalLight,
    HemisphereLight,
    PointLight,
    Renderer,
    GltfModel,
    PhongMaterial,
    Plane,
    Scene,
} from 'troisjs';
import WebXRPolyfill from 'webxr-polyfill'; // Import the polyfill
// props
const props = defineProps({
    buttonCondition: Boolean,
    threeD: String
})
const polyfill = new WebXRPolyfill();
// emits
const emit = defineEmits(['conditionDisplay'])

// variables
const arbutton = ref(null)
const renderer = ref(null)
const scene = ref(null)
const camera = ref(null)

const onFirstLoad = ref('')


const pixelRatio = ref(null)
const aspect = ref(null)
let init = ref(0)
let ende = ref(0)
// const target = ref(null)

const error = ref('')
const xrSupport = ref(false)
const currentSession = ref(null)

const model3d = ref(null)
const initialDistance = ref(null)
const scale = ref(1)

let touchStartEvent = null;

const scaleFactor = ref(1);
// methods

const onClick = () => {
    if (!xrSupport.value) return
    if (!renderer.value) return

    renderer.value.renderer.xr.setReferenceSpaceType('local')

    renderer.value.renderer.setSize(window.innerWidth, window.innerHeight)
    if (currentSession.value) {
        currentSession.value.end()
        renderer.value.renderer.clear()

    } else {
        const sessionInit = {
            optionalFeatures: ['dom-overlay'],
            domOverlay: { root: document.getElementById('roots') },
        }
        onFirstLoad.value = 'Exit AR'

        navigator.xr.requestSession('immersive-ar', sessionInit)
            .then(onSessionStarted)
    }

    if (props.buttonCondition === false) {
        ende.value++
        emit('conditionDisplay', [true, ende.value])
    }
}

const onSessionStarted = async (session) => {
    session.addEventListener('end', onSessionEnded)

    session.addEventListener('selectstart', onTouchStart, { xr: true });
    session.addEventListener('selectend', onTouchEnd, { xr: true });
    session.addEventListener('selectmove', onTouchMove, { xr: true });

    // currentSession.value = session;

    await renderer.value.renderer.xr.setSession(session)

    currentSession.value = session
}

const onSessionEnded = () => {
    currentSession.value.removeEventListener('end', onSessionEnded)
    currentSession.value.removeEventListener('selectstart', onTouchStart, { xr: true });
    currentSession.value.removeEventListener('selectend', onTouchEnd, { xr: true });
    currentSession.value.removeEventListener('selectmove', onTouchMove, { xr: true });
    currentSession.value = null
}

const onTouchStart = (event) => {

    if (event.touches.length === 2) {
        console.log(event);
        const dx = event.touches[0].pageX - event.touches[1].pageX
        const dy = event.touches[0].pageY - event.touches[1].pageY
        initialDistance.value = Math.sqrt(dx * dx + dy * dy)
    }
}

const onTouchMove = (event) => {
    if (event.touches.length === 2 && initialDistance.value) {
        const dx = event.touches[0].pageX - event.touches[1].pageX
        const dy = event.touches[0].pageY - event.touches[1].pageY
        const distance = Math.sqrt(dx * dx + dy * dy)
        const scaleFactor = distance / initialDistance.value
        scale.value *= scaleFactor
        model3d.value.scale.set(scale.value, scale.value, scale.value)
        initialDistance.value = distance
    }
}

const onTouchEnd = () => {
    touchStartEvent = null;
    initialDistance.value = null;
};


onBeforeMount(() => {
    if ('xr' in navigator) {
        navigator.xr.isSessionSupported('immersive-ar').then((supported) => {
            xrSupport.value = supported
        })
    } else {
        if (window.isSecureContext === false) {
            error.value = 'WEBXR NEEDS HTTPS'
        } else {
            error.value = 'WEBXR NOT AVAILABLE'
        }
    }

})

onMounted(() => {
    /// --- properties
    error, arbutton, renderer, error, xrSupport, currentSession, scene, camera

    /// ---- troisjs
    AmbientLight, Camera, DirectionalLight, HemisphereLight, Renderer, PhongMaterial, Plane, Scene, PointLight, GltfModel

    /// --- changes
    camera.value.camera.position.multiplyScalar( 2 )

    camera.value.camera.position.z = 5

    // onClick

    onFirstLoad.value = 'Enter AR'
    // Exit AR

    // console.log(init.value);

    /// ---- augmented reality -> will trigger immmediatly after the parent button for augmented reality display is clicked
    renderer.value.onAfterRender(() => {
        init.value++
        if (init.value === 1 && props.buttonCondition === false) {
            onClick()
        }
    })

    // methods
    // onClick

    // document events
    document.addEventListener('touchstart', onTouchStart, { passive: false })
    document.addEventListener('touchmove', onTouchMove, { passive: false })
})

onUnmounted(() => {
    init.value = 0
    ende.value = 0

    //document events
    document.removeEventListener('touchstart', onTouchStart)
    document.removeEventListener('touchmove', onTouchMove)
})

watchEffect(() => {
    pixelRatio.value = window.devicePixelRatio
    aspect.value = window.innerWidth / window.innerHeight
})



</script>

<template>

    <div class="fixed w-full py-5 left-1/4 bottom-5" id="roots" v-if="!props.buttonCondition">
        <button class="w-1/2 px-4 py-1 bg-white rounded-lg text-virtual-blue" ref="arbutton" @click="onClick">
            {{ onFirstLoad }}
        </button>
    </div>

    <div class="flex flex-col justify-center h-screen">
        <Renderer
        ref="renderer"
        antialias
        resize
        xr
        alpha
        autoClear
        :pixelRatio="pixelRatio"
        :clearColor="'rgba(0,0,0,0)'"
        :orbit-ctrl="{ enableDamping: true, dampingFactor: 0.05 }" >
            <Camera
            ref="camera"
            :far="1000"
            :fov="75"
            :aspect="aspect"
            :position="{ x: 100, y: 300, z: 5 }" />
            <Scene ref="scene">
                    <PointLight color="#ffffff" :intensity="0.5" />
                    <GltfModel
                    ref="model3d"
                    :position="{x: 0, y: -2, z: -5}"
                    :src="props.threeD"
                    />
            </Scene>
        </Renderer>
    </div>
</template>

