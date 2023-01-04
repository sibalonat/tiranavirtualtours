<script setup>
import { computed, onBeforeMount, onMounted, reactive, ref, watch } from '@vue/runtime-core';
// import { AnimationMixer, Clock, Fog, GridHelper, Vector3 } from 'three';
import { Vector3 } from 'three';
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
import ARButton from 'troisjs/src/components/misc/ARButton.vue'

// variables
const arbutton = ref(null)
const renderer = ref(null)
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

    if (currentSession.value) {
        currentSession.value.end()
    } else {
        const sessionInit = {
            optionalFeatures: ["dom-overlay", 'local-floor', 'local'],
        }
        console.log(sessionInit);
        navigator.xr.requestSession('immersive-ar', sessionInit).then(currentSession.value)
    }
}

const onSessionStarted = async (session) => {
    session.addEventListener('end', this.onSessionEnded)
    await renderer.value.xr.setSession(session)
    currentSession.value = session
}

onBeforeMount(() => {
    if ('xr' in navigator) {
        navigator.xr.isSessionSupported('immersive-ar').then((supported) => {
            xrSupport.value = supported
            console.log(xrSupport.value)
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
    // target.value = new Vector3(0, 100, 0)
    /// --- properties
    error, arbutton, renderer, error, xrSupport, currentSession

    /// ---- troisjs
    AmbientLight, Camera, DirectionalLight, FbxModel, HemisphereLight, Renderer, PhongMaterial, Plane, Scene, Vector3
    ARButton
    /// ---- augmented reality
    console.log(renderer.value);
    // arbutton.value.init(renderer.value.renderer)
    // init(renderer.value.renderer)

    // methods
    onLoad, onClick
})

</script>

<template>

    <!-- <ARButton ref="arbutton" :enter-message="'Enter AR'" :exit-message="'Leave AR'" /> -->
    <!-- <ARButton ref="arbutton" :enter-message="'Enter AR'" :exit-message="'Leave AR'" class="opacity-0" /> -->
    <button class="px-4 py-1" ref="arbutton" @click="onClick">une button ar</button>

    <div class="flex flex-col justify-center h-screen">
        <!-- <Renderer ref="renderer" antialias :orbit-ctrl="{ enableDamping: true, dampingFactor: 0.05, target }" resize shadow> -->
        <Renderer ref="renderer" antialias :orbit-ctrl="{ enableDamping: true, dampingFactor: 0.05 }" resize shadow>
            <Camera :position="{ x: 100, y: 200, z: 300 }" />
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
