<template>
    <vueper-slides   @before-init="logEvents"
                     @ready="logEvents"
                     @before-slide="logEvents"
                     @slide="logEvents"
                     fade
                   :touchable="false"
                   :slide-ratio="0.3"
                   :fixed-height="fullheight"
                   :pauseOnHover="false"
                   speed="10000"
                   slide-image-inside
                   autoplay>
        <i slot="arrowLeft" class="fa fa-chevron-left"></i>
        <i slot="arrowRight" class="fa fa-chevron-right"></i>

        <vueper-slide>
            <div slot="slideContent">

                <div class="welcome-text">
                    <transition
                            name="fade"
                            enter-active-class="animated fadeInUp">
                        <img v-if="load" class="img-fluid" src="/images/loader.png" style="animation-delay: 500ms; animation-duration: 2000ms"/>
                    </transition>

                    <transition
                            name="fade"
                            enter-active-class="animated zoomIn">
                        <img v-if="load" class="img-fluid" src="/images/jtg-manila-church.png" style="margin-top:25px; animation-delay: 1000ms; animation-duration: 3000ms"/>
                    </transition>
                </div>
                <div class="mouse2">
                    <a href="#" class="mouse-icon2">
                        <div class="mouse-wheel2"><i class="fa fa-chevron-circle-down"></i></div>
                    </a>
                </div>
            </div>
        </vueper-slide>
        <vueper-slide v-lazy:background-image="'/images/slider-lg-2-no-text.jpg'"
                      :style="'max-width: 100%; height: auto;'">
            <div slot="slideContent">
                <div class="welcome-text">
                    <transition
                            name="fade"
                            enter-active-class="animated fadeInLeft">
                        <img v-if="load" class="img-fluid" src="/images/slider-2-1.png" style="margin-top:25px; animation-delay: 500ms; animation-duration: 4000ms"/>
                    </transition>

                    <transition
                            name="fade"
                            enter-active-class="animated fadeInRight">
                        <img v-if="load" class="img-fluid slider2" src="/images/slider-2-2.png" style="animation-delay: 2500ms; animation-duration: 4000ms"/>
                    </transition>
                </div>
                <div class="mouse2">
                    <a href="#" class="mouse-icon2">
                        <div class="mouse-wheel2"><i class="fa fa-chevron-circle-down"></i></div>
                    </a>
                </div>
            </div>
        </vueper-slide>

        <vueper-slide v-lazy:background-image="'/images/slider-lg-3.jpg'"
                      :style="'max-width: 100%; height: auto;'">
            <div slot="slideContent">
                <div class="mouse2">
                    <a href="#" class="mouse-icon2">
                        <div class="mouse-wheel2"><i class="fa fa-chevron-circle-down"></i></div>
                    </a>
                </div>
            </div>
        </vueper-slide>
        <vueper-slide v-lazy:background-image="'/images/slider-lg-4.jpg'"
                      :style="'max-width: 100%; height: auto;'">
            <div slot="slideContent">
                <div class="mouse2">
                    <a href="#" class="mouse-icon2">
                        <div class="mouse-wheel2"><i class="fa fa-chevron-circle-down"></i></div>
                    </a>
                </div>
            </div>
        </vueper-slide>
    </vueper-slides>
</template>

<style>
    .vueperslides__arrow {
        background: #fff !important;
        width: 2em !important;
        height: 2em !important;
        border-radius: 100% !important;
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        opacity: 1 !important;
        font-size: 2rem !important;
    }

    .slider2 {
        margin-top: -80px;
    }

    @media (min-width: 0) {
        .slider2 {
            margin-top: -30px;
        }
    }

    @media (min-width: 576px) {
        .slider2 {
            margin-top: -80px;
        }
    }
</style>

<script>
    export default {
        props: [
            'images'
        ],

        data() {
            return {
                load: false,

                breakpoints: {
                    1200: {
                        slideRatio: 1 / 5
                    },
                    900: {
                        slideRatio: 1 / 3
                    },
                    600: {
                        slideRatio: 1 / 2,
                        arrows: false,
                        bulletsOutside: true
                    },
                    // The order you list breakpoints does not matter, Vueper Slides will sort them for you.
                    1100: {
                        slideRatio: 1 / 4
                    }
                },

                fullheight: '0px',

                load: false
            }
        },

        watch: {

        },

        computed: {

        },

        mounted() {
            this.load != this.load;

            this.fullheight = $(window).height() + 'px';
//            console.log($(window).height());
//            $(window).height()
            this.$nextTick(function() {
                window.addEventListener('resize', this.getWindowHeight);

                //Init
                this.getWindowHeight()
            })
        },

        methods: {
            getWindowHeight(event) {
                this.fullheight = $(window).height() + 'px';
            },

            logEvents (eventName, params) {
                if (eventName == 'before-slide') {
                    this.load = false;
                    this.$nextTick(() => {
                        this.load = true;
                    })
                }

                if (eventName == 'slide') {

                }
                if (eventName == 'ready') {
                    if (params.currentSlide.index == 0) {
                        this.load = true;
                    }
                }

//                this.events += ` ${eventName},  ${JSON.stringify(params, null, 0)}`
            }
        }

    }
</script>