<script setup>

import { Head, Link } from '@inertiajs/inertia-vue3';
import { onMounted, ref } from '@vue/runtime-core';


// heroicons
import { FlagIcon, InformationCircleIcon, Cog6ToothIcon, ChevronLeftIcon } from '@heroicons/vue/24/outline'

// threejs
import { Object3D, MathUtils } from 'three';

// troisjs
import {
    Camera,
    EffectComposer,
    InstancedMesh,
    PhongMaterial,
    Renderer,
    RenderPass,
    SphereGeometry,
    SpotLight,
    Scene,
    UnrealBloomPass,
} from 'troisjs';



const prop = defineProps({
    tours: Array
})

let NUM_INSTANCES = ref(8)
let renderer = ref(null)
let imesh = ref(null)
let scene = ref(null)

onMounted(() => {
    Head, Link
    FlagIcon, InformationCircleIcon, Camera, EffectComposer, InstancedMesh, PhongMaterial, Renderer, RenderPass, SphereGeometry,
        SpotLight, Scene, UnrealBloomPass

    // threejs
    if (renderer.value) {
        // const imes = imesh.value.mesh;
        // const imes = imesh.value;
        // console.log(imes);
        console.log(imesh.value);
        const dummy = new Object3D();
        const { randFloat: rnd, randFloatSpread: rndFS } = MathUtils;
        for (let i = 0; i < NUM_INSTANCES.value; i++) {
            dummy.position.set(rndFS(200), rndFS(200), rndFS(200));
            const scale = rnd(0.2, 1);
            dummy.scale.set(scale, scale, scale);
            dummy.updateMatrix();
            imesh.value.mesh.setMatrixAt(i, dummy.matrix);
        }
        imesh.value.mesh.instanceMatrix.needsUpdate = true;
    }

    // console.log(prop.tours);
})

</script>

<template>

    <Head title="Journeys" />
    <div>
        <div class="relative max-w-full mx-auto sm:px-6 lg:px-8 bg-virtual-blue">
            <div class="relative flex flex-col justify-center h-screen">
                <!-- <Renderer ref="renderer" resize
                    :orbit-ctrl="{ enableDamping: true, dampingFactor: 0.05, autoRotate: true }" shadow alpha antialias
                    autoClear> -->
                <Renderer ref="renderer" resize
                    :orbit-ctrl="{ enableDamping: true, dampingFactor: 0.05, autoRotate: true }" shadow alpha antialias
                    autoClear>
                    <Camera :position="{ y: 100, z: 100 }" />
                    <Scene ref="scene">
                        <SpotLight color="#ffffff" :intensity="0.5" :position="{ y: 150, z: 0 }" :cast-shadow="true"
                            :shadow-map-size="{ width: 1024, height: 1024 }" />
                        <SpotLight color="#ff0000" :intensity="0.5" :position="{ y: -150, z: 0 }" :cast-shadow="true"
                            :shadow-map-size="{ width: 1024, height: 1024 }" />
                        <InstancedMesh ref="imesh" :count="NUM_INSTANCES" :cast-shadow="true" :receive-shadow="true">
                            <SphereGeometry :radius="5" />
                            <PhongMaterial />
                        </InstancedMesh>
                    </Scene>
                    <EffectComposer>
                        <RenderPass />
                        <UnrealBloomPass :strength="2" />
                    </EffectComposer>
                </Renderer>
            </div>
        </div>
    </div>
</template>
