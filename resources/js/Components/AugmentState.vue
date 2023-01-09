<script setup>
import { onBeforeMount, onMounted, ref, watchEffect } from '@vue/runtime-core';

import {
    AmbientLight,
    Camera,
    DirectionalLight,
    FbxModel,
    HemisphereLight,
    PointLight,
    Renderer,
    PhongMaterial,
    Plane,
    Scene,
} from 'troisjs';
import { Vector3 } from 'three';

// props
const props = defineProps({
    buttonCondition: Boolean
})

// variables
const arbutton = ref(null)
const renderer = ref(null)
const scene = ref(null)
const camera = ref(null)


const pixelRatio = ref(null)
const aspect = ref(null)
let init = ref(0)
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
    } else {
        const sessionInit = {
            optionalFeatures: ['dom-overlay'],
            domOverlay: { root: document.getElementById('roots') },
        }

        navigator.xr.requestSession('immersive-ar', sessionInit)
            .then(onSessionStarted)
    }
}

const onSessionStarted = async (session) => {
    session.addEventListener('end', onSessionEnded)

    await renderer.value.renderer.xr.setSession(session)

    console.log(session);

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
    AmbientLight, Camera, DirectionalLight, FbxModel, HemisphereLight, Renderer, PhongMaterial, Plane, Scene, Vector3, PointLight

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

watchEffect(() => {

    pixelRatio.value = window.devicePixelRatio
    aspect.value = window.innerWidth / window.innerHeight
})



</script>

<template>

    <!-- <div class="fixed py-5" id="roots" v-if="!props.textButton">
        <button class="px-4 py-1" ref="arbutton" @click="onClick">une button ar</button>
    </div> -->
    <!--  -->


    <div class="flex flex-col justify-center h-screen">
        <!-- <Renderer ref="renderer" antialias :orbit-ctrl="{ enableDamping: true, dampingFactor: 0.05 }" resize shadow xr alpha> -->
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
                <!-- <HemisphereLight />
                <DirectionalLight :position="{ x: 0, y: 200, z: 100 }" cast-shadow
                    :shadow-camera="{ top: 180, bottom: -120, left: -120, right: 120 }" /> -->
                    <!-- <AmbientLight /> -->
                    <PointLight color="#ffffff" :intensity="0.5" />
                    <!-- :position="{x: 0, y: 400, z: 0}" -->
                    <FbxModel
                    ref="model3d"
                    :position="{x: 0, y: 0, z: -400}"
                    :src="'/images/BreadAndWifi.fbx'"
                    @load="onLoad" />
            </Scene>
        </Renderer>
    </div>

</template>
