<template>
    <div>
        <div class="hero-wrap js-fullheight" v-lazy:background-image="image" :style="{'height' : fullheight}"  data-stellar-background-ratio="0.5">
            <div class="overlay"></div>
            <div class="container">
                <div :style="{ 'height' : fullheight}" class="row no-gutters slider-text2 js-fullheight align-items-center justify-content-center" data-scrollax-parent="true">
                    <div class="col-md-10 text-center jtg-animate" data-scrollax="properties: { translateY: '70%' }">
                        <h1 class="mb-0">OUR STORY</h1>
                        <!--<h3 class="subheading mb-4 pb-1">On March 2009, Blenn and Manel launched the 1st JTG Manila Church Service with only 5 people and since then by the grace of God, it never stops growing.</h3>-->

                        <div class="mouse">
                            <a href="#" class="mouse-icon">
                                <div class="mouse-wheel"><span class="fa fa-chevron-circle-down"></span></div>
                            </a>
                        </div>

                        <!--<p>-->
                            <!--<button @click="showModal" type="button" class="btn btn-history p-0">-->
                                <!--<i class="fa fa-play-circle-o fa-4x"></i>-->
                            <!--</button>-->
                        <!--</p>-->
                    </div>
                </div>
            </div>
        </div>
        <sweet-modal width="100%" ref="modal" modal-theme="dark" overlay-theme="dark" @close="closeModal" class="sModalHistory">
            <strong>OUR STORY</strong>
            <br/><br/>

            <template v-if="windowWidth != ''">
                <series-youtube-video :video-id="'hG-PQSoeBNc'"
                                      :player-width="windowWidth"
                                      :player-height="windowHeight"></series-youtube-video>
            </template>
        </sweet-modal>
    </div>
</template>

<style>
    /*.js-fullheight {*/
        /*height: 100%*/
    /*}*/
</style>

<script>
    export default {
        props : ['title', 'image'],

        data() {
            return {
                windowWidth: '',
                windowHeight: '',

                errors: [],

                fullheight: '0px'
            }
        },

        mounted() {
            this.fullheight = $(window).height() + 'px';

            this.getWindowHeight();

            this.$nextTick(function() {
                window.addEventListener('resize', this.getWindowWidth);
                window.addEventListener('resize', this.getWindowHeight);

                //Init
                this.getWindowWidth()
                this.getWindowHeight()
            })
        },

        methods: {
            showModal() {
                this.$refs.modal.open();
            },

            closeModal() {
                console.log('closed');
            },

            getWindowWidth(event) {
                this.windowWidth = document.documentElement.clientWidth - 100;
            },

            getWindowHeight(event) {
                this.fullheight = $(window).height() + 'px';
            }
        }

    }
</script>