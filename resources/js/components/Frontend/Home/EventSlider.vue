<template>
    <vueper-slides fade slide-content-outside="top" :touchable="false" :slide-ratio="0.3"
                   :pauseOnHover="false"
                   :slide-content-outside="false"
                   autoplay>
        <i slot="arrowLeft" class="icon icon-chevron-left"></i>
        <i slot="arrowRight" class="icon icon-chevron-right"></i>

        <vueper-slide v-for="(event, i) in events"
                      :image="event.image_src"
                      :key="event.id">
            <div slot="slideContent">
                <!--<div class="jtg-event-entry align-self-stretch">-->
                    <!--<a :href="'/events/' + event.id" class="block-20" :style="{ 'background-image': 'url(' + event.image_src + ')'}">-->
                    <!--</a>-->
                    <!--<div class="text p-4 d-block">-->
                        <!--<h3 class="heading mb-1 text-center"><a href="#">{{ event.name }}</a></h3>-->
                        <!--<p class="time-loc text-center">-->
                            <!--<h6 class="mr-2 font-weight-bold text-center">-->
                                <!--&lt;!&ndash;@if ($event->starting_at->format('Y-m-d') == $event->ending_at->format('Y-m-d'))&ndash;&gt;-->
                                    <!--&lt;!&ndash;{{ $event->starting_at->format('M d') }} @ {{ $event->starting_at->format('g:iA') }} - {{ $event->starting_at->format('g:iA') }}&ndash;&gt;-->
                                        <!--&lt;!&ndash;@else&ndash;&gt;-->
                                            <!--&lt;!&ndash;{{ $event->starting_at->format('M d') }} - {{ $event->ending_at->format('M d Y') }}&ndash;&gt;-->
                                        <!--&lt;!&ndash;@endif&ndash;&gt;-->
                                        <!--&lt;!&ndash;<br>&ndash;&gt;-->
                                <!--&lt;!&ndash;@if ($event->address)&ndash;&gt;-->
                                    <!--&lt;!&ndash;<span class="small">{{ $event->address }}</span>&ndash;&gt;-->
                                <!--&lt;!&ndash;@endif&ndash;&gt;-->
                            <!--</h6>-->
                        <!--</p>-->
                        <!--<p>{{ event.description }}</p>-->
                    <!--</div>-->
                <!--</div>-->
                <!--<h6>-->
                <!--BE INFORMED-->
                <!--</h6>-->
                <!--<a class="btn text-white py-3 px-4" style="font-size: 60px; letter-spacing: 1px; font-weight: 600;" href="/about/vision">-->
                <!--BE INFORMED.-->
                <!--STAY-->
                <!--</a>-->
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

    .welcome-text {
        position: relative;
        z-index: 1;
    }
    .welcome-text h2 {
        font-weight: 700;
        font-size: 82px;
        display: block;
        margin-bottom: 0;
        background: -webkit-linear-gradient(#ff9696, #ffe89e);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .welcome-text p {
        color: #fff;
        margin-bottom: 50px;
        display: block;
    }
    .welcome-text .hero-mail-contact {
        color: #fff;
        font-style: italic;
        text-decoration: underline;
    }
    .welcome-text .hero-mail-contact:hover {
        color: #fc6060;
    }
    .welcome-text .hero-mail-contact:focus {
        color: #fc6060;
    }

</style>

<script>
    export default {
        props: [
            'events'
        ],

        data() {
            return {
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

                fullheight: '0px'
            }
        },

        watch: {

        },

        computed: {

        },

        mounted() {
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
            }
        }

    }
</script>