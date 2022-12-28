<script setup>

import { Head, Link } from '@inertiajs/inertia-vue3';
import { computed, onMounted, reactive, ref } from '@vue/runtime-core';
import _ from 'lodash';


// import Matter from "matter-js";
import { Engine, World, Bodies, Composite, Common, Composites, Mouse, MouseConstraint, Runner } from "matter-js";

// p5
import P5 from 'p5'
// console.log(p5);
// heroicons
import { FlagIcon, InformationCircleIcon, Cog6ToothIcon, ChevronRightIcon } from '@heroicons/vue/24/outline'



const prop = defineProps({
    tours: Array
})

//variables
let arraySpanSizes = ['2', '3', '4', '5']

let arrSpostime = ['1', '2', '3', '4', '5', '6', '7', '8', '8', '10']
let arrayClasses = [
    {
        className: "-i1",
    },
    {
        className: "-i2",
    },
    {
        className: "-i3",
    },
    {
        className: "-i4",
    },
    {
        className: "-i5",
    },
]
let testarr = ref(6)

var engine = ref(null);
var world = ref(null);
var bodies = ref(null);

var canvas = ref(null);

var mouseConstraint = ref(null);

var params = reactive({
    restitution: 0.7,
    friction: 0.2
})

let arrayTochange = ref([])

//methods

const makeCircle = (x, y) => {
    //  return Bodies.circle(x, y, 32, params);
    return Bodies.circle(x, y, 10 + Common.random() * 150, [{
        isStatic: false,
        restitution: 0.5,
        friction: 0.2
    }])
}

const startFallbox = () => {

    new P5(function (p5) {

        p5.setup = () => {

            canvas.value = p5.createCanvas(p5.windowWidth, p5.windowHeight)
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


            Composite.add(world.value, ground);
            Composite.add(world.value, wall1);
            Composite.add(world.value, wall2);

            var stack = Composites.stack(20, 50, 5, 8, 10, 10, makeCircle);
            bodies.value = stack.bodies;

            // add all of the bodies to the world
            World.add(world.value, stack);

            // run the engine
            Runner.run(engine.value);

        }


        p5.draw = () => {
            // p5.background('blue')
            p5.background('#0019DA')
            // p5.strokeWeight(1);
            // p5.fill("#0EFF00");
            // p5.circle(p5.mouseX, p5.mouseY, 40);


            for (var i = 0; i < bodies.value.length; i++) {
                var circleL = bodies.value[i];

                var pos = circleL.position;
                var r = circleL.circleRadius;
                var angle = circleL.angle;


                var fontSize = 38;

                // p5.textSize(fontSize);

                p5.textSize(r/1.8);

                var txt1 = "Betty"
                var wordWith = p5.textWidth(txt1);

                p5.push();
                p5.translate(pos.x, pos.y);
                p5.rotate(angle);

                // set rectangle in background, change fill to solid color to see it

                p5.ellipseMode(p5.CENTER);
                p5.noStroke();

                // p5.fill(255, 0, 0, 0);
                p5.fill("#E5E7EB");

                p5.circle(0, 20, r * 1.9);




                // set text
                // p5.fill(255);
                p5.fill("#0019DA");

                p5.textAlign(p5.CENTER, p5.CENTER);

                p5.text(txt1, 0, fontSize / 2);

                p5.pop();
            }
        }
    })

}



onMounted(() => {
    Head, Link
    FlagIcon, InformationCircleIcon, ChevronRightIcon

    // properties
    testarr, arraySpanSizes, arrSpostime

    console.log(prop.tours);
    startFallbox();

    // console.log(Matter);



})

</script>

<template>

    <Head title="Journeys" />
    <div>
        <div class="relative max-w-full mx-auto sm:px-6 lg:px-8 bg-virtual-blue">
            <div class="relative flex flex-col justify-center h-screen" id="falling-scene">
                <!-- <div v-for="(item, i) in arrayClasses" :key="item.className" class="block" :id="`block-${i}`">
                    <span :class="item.className" class="item">une {{ i }}</span>
                </div> -->
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
#block {
    width: 100px;
    height: 100px;
    background-color: red;
}

.fallbox {
    position: relative;
    height: 100vh;
    width: 100%;
    margin: auto;
    background: black;
    overflow: hidden;

    .fallbox-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 95%;
        max-width: 1050px;
        z-index: 2;

        // -khtml-user-select: none;
        // -moz-user-select: none;
        // -ms-user-select: none;
        // user-select: none;
        // pointer-events: none;

        h1 {
            font-size: 160px;
            font-weight: 500;
            line-height: 140px;
            margin-bottom: 150px;
            text-align: center;
            color: white;
        }
    }

    .fallbox-scene {
        height: 100%;
        width: 100%;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 1;
        contain: strict;

        .item {
            height: 120px;
            width: 120px;
            background: red;
            position: absolute;
            opacity: 0;
            user-select: none;
            will-change: transform;

            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            pointer-events: none;
        }
    }
}
</style>
