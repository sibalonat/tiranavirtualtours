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

// props
const props = defineProps({
    buttonCondition: Boolean
})

// emits
const emit = defineEmits(['conditionDisplay'])

// variables
const arbutton = ref(null)
const renderer = ref(null)
const scene = ref(null)
const camera = ref(null)


const pixelRatio = ref(null)
const aspect = ref(null)
let init = ref(0)
let ende = ref(0)
// const target = ref(null)

const error = ref('')
const xrSupport = ref(false)
const currentSession = ref(null)

// methods
const onLoad = (object) => {
    console.log(object);
}



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

    await renderer.value.renderer.xr.setSession(session)

    console.log(session);
    console.log(renderer.value);

    currentSession.value = session
}

const onSessionEnded = () => {
    currentSession.value.removeEventListener('end', onSessionEnded)
    currentSession.value = null
}

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
    /// ---- dt

    /// --- properties
    error, arbutton, renderer, error, xrSupport, currentSession, scene, camera

    /// ---- troisjs
    AmbientLight, Camera, DirectionalLight, HemisphereLight, Renderer, PhongMaterial, Plane, Scene, PointLight, GltfModel

    /// --- changes
    camera.value.camera.position.multiplyScalar( 2 )

    /// ---- augmented reality -> will trigger immmediatly after the parent button for augmented reality display is clicked
    renderer.value.onAfterRender(() => {
        console.log('here it plays');
        init.value++
        if (init.value === 1 && props.buttonCondition === false) {
            onClick()
        }
    })


    // methods
    onLoad, onClick
})

onUnmounted(() => {
    init.value = 0
    ende.value = 0
})

watchEffect(() => {
    pixelRatio.value = window.devicePixelRatio
    aspect.value = window.innerWidth / window.innerHeight
})



</script>

<template>

    <div class="fixed py-5" id="roots" v-if="!props.buttonCondition">
        <button class="px-4 py-1" ref="arbutton" @click="onClick">une button ar</button>
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
        :orbit-ctrl="{ enableDamping: true, dampingFactor: 0.05 }" >
            <Camera
            ref="camera"
            :far="1000"
            :fov="75"
            :aspect="aspect"
            :position="{ x: 100, y: 300, z: 1 }" />
            <Scene ref="scene">
                    <PointLight color="#ffffff" :intensity="0.5" />
                    <GltfModel
                    ref="model3d"
                    :position="{x: 0, y: -2, z: -5}"
                    :src="'/images/breadandwifi.glb'"
                    @load="onLoad" />
            </Scene>
        </Renderer>
    </div>
</template>

