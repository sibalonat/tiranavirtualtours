<script setup>

import { Head, Link } from '@inertiajs/inertia-vue3';
import { computed, onMounted, reactive, ref } from '@vue/runtime-core';
import _ from 'lodash';


// import Matter from "matter-js";
import { Engine, Bodies, Composite, Common, Mouse, MouseConstraint, Runner } from "matter-js";

// p5
import P5 from 'p5'
// console.log(p5);
// heroicons
import { FlagIcon, InformationCircleIcon, Cog6ToothIcon, ChevronRightIcon } from '@heroicons/vue/24/outline'
import { Inertia } from '@inertiajs/inertia';

const prop = defineProps({
    tours: Array
})

//variables
let arrayEl = [
    {
        name: 'tour 1',
        to: 'https://tiranavirtualtours.test/journeys/507806a7-5aea-4732-aa48-79fd78ce6f8b',
    },
    {
        name: 'tour 2',
        to: 'https://tiranavirtualtours.test/journeys/507806a7-5aea-4732-aa48-79fd78ce6f8b',
    },
    {
        name: 'tour 3',
        to: 'https://tiranavirtualtours.test/journeys/507806a7-5aea-4732-aa48-79fd78ce6f8b',
    },
    {
        name: 'tour 4',
        to: 'https://tiranavirtualtours.test/journeys/507806a7-5aea-4732-aa48-79fd78ce6f8b',
    },
    {
        name: 'tour 5',
        to: 'https://tiranavirtualtours.test/journeys/507806a7-5aea-4732-aa48-79fd78ce6f8b',
    },
]



var engine = ref(null);
var world = ref(null);
var bodies = ref(null);

var canvas = ref(null);

var mouseConstraint = ref(null);

var params = reactive({
    restitution: 0.7,
    friction: 0.2,
})

//methods
const startFallbox = () => {

    new P5(function (p5) {
        const makeCircle = (x, y, anchor, writing) => {
            return Bodies.circle(x, y, 10 + Common.random() * 150, [{
                isStatic: false,
                params,
                frictionAir: p5.random(0.001, 0.2),
                render: {
                    link: anchor,
                    name: writing
                }
            }])
        }

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

            Composite.add(world.value, [
                // walls
                ground,
                wall1,
                wall2
            ]);

            let stacket = arrayEl.map((el) => {
                return makeCircle(20, 50, el.to, el.name)
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

                var fontSize = 38;

                p5.textSize(r / 1.8);

                var txt1 = `${text}`
                // var txt1 = "Betty"
                p5.textWidth(txt1);

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
        p5.mousePressed = () => {
            bodies.value.forEach(e => {
                var d = p5.dist(p5.mouseX, p5.mouseY, e.position.x, e.position.y);
                if (d <= e.circleRadius) {
                    Inertia.visit(e[0].render.link, { replace: true })
                }
            })
        }
    })
}

onMounted(() => {
    Head, Link
    FlagIcon, InformationCircleIcon, ChevronRightIcon

    // properties
    console.log(prop.tours);
    //methods
    startFallbox();

})

</script>

<template>

    <Head title="Journeys" />
    <div>
        <div class="relative max-w-full mx-auto sm:px-6 lg:px-8 bg-virtual-blue">
            <div class="absolute z-50 w-full text-white bg-virtual-blue">
                <p
                    class="w-full py-8 mx-auto my-auto mb-0 text-2xl leading-none text-center align-text-bottom font-regular">
                    Choose a tour to start
                </p>
            </div>
            <div class="relative flex flex-col justify-center h-screen" id="falling-scene">

            </div>
        </div>
    </div>
</template>

