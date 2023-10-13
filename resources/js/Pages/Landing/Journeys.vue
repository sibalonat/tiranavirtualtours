<script setup>

import { Head, Link } from '@inertiajs/vue3';
import { computed, onBeforeMount, onMounted, onUnmounted, reactive, ref, watch } from '@vue/runtime-core';
import _ from 'lodash';


// import Matter from "matter-js";
import { Engine, Bodies, Composite, Common, Mouse, MouseConstraint, Runner } from "matter-js";

// p5
import P5 from 'p5'

// heroicons
import { FlagIcon, InformationCircleIcon, Cog6ToothIcon, ChevronRightIcon } from '@heroicons/vue/24/outline'

import { router } from '@inertiajs/vue3'
import { breakpointsTailwind, useBreakpoints } from '@vueuse/core'


const prop = defineProps({
    tours: Array
})

//variables
let arrayEl = ref([])


// breakpoints
const breakpoints = useBreakpoints(breakpointsTailwind)
// const smAndLarger = breakpoints.greaterOrEqual('sm')
const smAndLarger = breakpoints.greater('sm')

var engine = ref(null);
var world = ref(null);
var bodies = ref(null);
var p5bodies = ref([]);

var canvas = ref(null);

let p5Instance = ref(null);

var mouseConstraint = ref(null);

var params = reactive({
    restitution: 0.7,
    friction: 0.2,
})

//methods
const startFallbox = () => {

    p5Instance.value = new P5(function (p5) {
        const makeCircle = (x, y, anchor, writing) => {
            if (smAndLarger.value) {
                return Bodies.circle(x, y, 30 + Common.random() * 180, [{
                    isStatic: false,
                    params,
                    frictionAir: p5.random(0.001, 0.2),
                    render: {
                        link: route('landing.tourone', { tour: anchor }),
                        name: writing
                    }
                }])
            } else {
                return Bodies.circle(x, y, 10 + Common.random() * 130, [{
                    isStatic: false,
                    params,
                    frictionAir: p5.random(0.001, 0.2),
                    render: {
                        link: route('landing.tourone', { tour: anchor }),
                        name: writing
                    }
                }])
            }
        }

        p5.setup = () => {
            if (smAndLarger.value) {
                canvas.value = p5.createCanvas(p5.windowWidth - 32, p5.windowHeight - 32)
            } else {
                canvas.value = p5.createCanvas(p5.windowWidth, p5.windowHeight)
            }
            canvas.value.parent('falling-scene');
            p5.frameRate(60);
            engine.value = Engine.create();
            world.value = engine.value.world;
            var mouse = Mouse.create(canvas.value.elt);
            var mouseParams = {
                mouse: mouse,
                constraint: {
                    stiffness: 0.2,
                }
            }
            mouseConstraint.value = MouseConstraint.create(engine, mouseParams);
            mouseConstraint.value.mouse.pixelRatio = p5.pixelDensity();
            Composite.add(world.value, mouseConstraint.value);
            // console.log(canvas.value);

            // Set walls
            var params = {
                isStatic: true
            }

            var ground = Bodies.rectangle(p5.width / 2, p5.height, p5.width, 50, params);
            var wall1 = Bodies.rectangle(0, p5.height / 2, 50, p5.height, params);
            var wall2 = Bodies.rectangle(p5.width, p5.height / 2, 50, p5.height, params);

            Composite.add(world.value, [
                // walls
                ground,
                wall1,
                wall2
            ]);


            let stacket = arrayEl.value.map((el) => {
                return makeCircle(20, 50, el.slug, el.title)
            });


            bodies.value = stacket;

            Composite.add(world.value, stacket);

            // run the engine
            Runner.run(engine.value);
        }

        p5.draw = () => {

            p5.background('#0019DA')
            // p5.strokeWeight(1);
            // p5.fill("#0EFF00");
            // p5.circle(p5.mouseX, p5.mouseY, 40);

            for (var i = 0; i < bodies.value.length; i++) {
                var circleL = bodies.value[i];

                var pos = circleL.position;
                var r = circleL.circleRadius;

                var angle = circleL.angle;
                var text = circleL[0].render.name
                // console.log(text);

                var fontSize = 12;

                p5.textSize(r / 6);

                var txt1 = `${text}`
                // var txt1 = "Betty"
                p5.textWidth(txt1 / 9);

                p5.push();
                p5.translate(pos.x, pos.y);
                p5.rotate(angle);

                // set rectangle in background, change fill to solid color to see it

                p5.ellipseMode(p5.CENTER);
                p5.noStroke();

                // p5.fill(255, 0, 0, 0);
                p5.fill("#E5E7EB");

                p5.circle(0, 3, r * 1.9);

                // set text
                // p5.fill(255);
                p5.fill("#0019DA");

                p5.textAlign(p5.CENTER, p5.CENTER);

                p5.text(txt1, 0, fontSize / 2);

                p5.pop();
            }
        }
        p5.mousePressed = () => {
            bodies.value.forEach(e => {
                var d = p5.dist(p5.mouseX, p5.mouseY, e.position.x, e.position.y);
                if (d < e.circleRadius / 1.9) {
                    goToPage(e[0].render)
                }
            })
        }
    })
}

const goToPage = (e) => {
    router.visit(e.link, { replace: true })
}

onBeforeMount(() => {
    arrayEl.value = prop.tours
})

onMounted(() => {
    Head, Link
    FlagIcon, InformationCircleIcon, ChevronRightIcon

    // properties

    //methods
    startFallbox();

})

onUnmounted(() => {
    canvas.value.canvas.removeEventListener('click', goToPage)

    // Remove the canvas element
    if (canvas.value) {
        canvas.value.remove();
        canvas.value = null;
    }

    // Stop the p5 sketch
    if (p5Instance.value) {
        p5Instance.value.remove();
        p5Instance.value = null;
    }

    // Clear Matter.js world and engine
    if (world.value) {
        // Remove the mouseConstraint from the world
        if (mouseConstraint.value) {
            Composite.remove(world.value, mouseConstraint.value);
            mouseConstraint.value = null;
        }

        Composite.clear(world.value, true);
        world.value = null;
    }

    if (engine.value) {
        Engine.clear(engine.value);
        engine.value = null;
    }

    // Also, clear your bodies array
    bodies.value = [];
})

watch(p5bodies, (val) => {
    console.log(val);
})

</script>

<template>

    <Head title="TFT - Tours" />
    <div class="overflow-x-hidden ">
        <div class="relative w-screen max-w-full mx-auto sm:px-6 lg:px-8 bg-virtual-blue">
            <div class="absolute z-50 w-full text-white bg-virtual-blue">
                <p v-if="!smAndLarger"
                    class="w-full py-8 mx-auto my-auto mb-0 text-2xl leading-none text-center align-text-bottom font-regular">
                    Choose a tour to start
                </p>
                <div class="grid grid-cols-6 gap-4" v-else>
                    <div class="grid grid-cols-12 col-span-4">
                        <Link class="grid grid-cols-12 col-span-12" :href="route('welcome')">
                            <img :src="'/images/logo.svg'" class="block w-1/2 col-span-1 mx-auto" alt="">
                            <div class="col-span-8 my-auto">
                                <p class="text-3xl">Tirana Floating Tours</p>
                            </div>
                        </Link>
                    </div>
                    <div class="my-auto">
                        <div class="grid grid-cols-2 gap-x-7">
                            <Link class="col-span-2 px-3 py-1 text-center text-white no-underline border border-white" :href="route('landing.about')">
                                    About
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative flex flex-col justify-center w-screen h-screen" id="falling-scene">

            </div>
        </div>
    </div>
</template>

