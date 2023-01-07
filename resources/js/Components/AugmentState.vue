<script setup>
import { onBeforeMount, onMounted, ref } from '@vue/runtime-core';

import {
    AmbientLight,
    Camera,
    DirectionalLight,
    FbxModel,
    HemisphereLight,
    Renderer,
    PhongMaterial,
    Plane,
    Scene,
} from 'troisjs';

// props
const props =  defineProps({
    buttonCondition: Boolean
})

// variables
const arbutton = ref(null)
const renderer = ref(null)
// let render = ref(false)
let init = ref(0)
// const target = ref(null)

const error = ref('')
const xrSupport = ref(false)
const currentSession = ref(null)

// methods
const onLoad = (object) => {
    // console.log(object);
}

const onClick = () => {
    if (!xrSupport.value) return
    if (!renderer.value) return

    if (currentSession.value) {
        currentSession.value.end()
    } else {
        const sessionInit = {
            optionalFeatures: ['dom-overlay', 'local-floor', 'local'],
            requiredFeatures: ['local', 'hit-test'],
            domOverlay: { root: document.getElementById('roots') },
        }
        navigator.xr.requestSession('immersive-ar', sessionInit)
            .then(onSessionStarted)
    }
}

const onSessionStarted = async (session) => {
    session.addEventListener('end', onSessionEnded)

    await renderer.value.renderer.xr.setSession(session)

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
    error, arbutton, renderer, error, xrSupport, currentSession

    /// ---- troisjs
    AmbientLight, Camera, DirectionalLight, FbxModel, HemisphereLight, Renderer, PhongMaterial, Plane, Scene

    /// ---- augmented reality -> will trigger immmediatly after the parent button for augmented reality display is clicked
    renderer.value.onAfterRender(() => {
        console.log('here it plays');
        init.value++
        if (init.value === 1 && props.buttonCondition === false) {
            // onClick()
        }
    })

    // methods
    onLoad, onClick
})



</script>

<template>

    <div class="fixed py-5" id="roots" v-if="!props.textButton">
        <button class="px-4 py-1" ref="arbutton" @click="onClick">une button ar</button>
    </div>
    {{ props.textButton }}

    <div class="flex flex-col justify-center h-screen">
        <!-- <Renderer ref="renderer" antialias :orbit-ctrl="{ enableDamping: true, dampingFactor: 0.05, target }" resize shadow> -->
        <Renderer ref="renderer" antialias :orbit-ctrl="{ enableDamping: true, dampingFactor: 0.05 }" resize shadow xr>
            <!-- <Camera :position="{ x: 100, y: 200, z: 300 }" /> -->
            <Camera :position="{ x: 100, y: 200, z: 1000 }" />
            <Scene ref="scene" background="#a0a0a0">
                <HemisphereLight />

                <DirectionalLight :position="{ x: 0, y: 200, z: 100 }" cast-shadow
                    :shadow-camera="{ top: 180, bottom: -120, left: -120, right: 120 }" />

                <Plane :width="2000" :height="2000" :rotation="{ x: -Math.PI / 2 }" receive-shadow>
                    <PhongMaterial color="#999999" :props="{ depthWrite: false }" />
                </Plane>

                <FbxModel :src="'/images/BreadAndWifi.fbx'" @load="onLoad" />
            </Scene>
        </Renderer>
    </div>

</template>
