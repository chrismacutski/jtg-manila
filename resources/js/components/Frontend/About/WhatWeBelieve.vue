<template>
    <div class="hero-wrap js-fullheight" v-lazy:background-image="image" :style="{'height' : fullheight}" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div :style="{'height' : fullheight}" class="row no-gutters slider-text js-fullheight align-items-center justify-content-center" data-scrollax-parent="true">
                <div class="col-md-10 text-center jtg-animate" data-scrollax=" properties: { translateY: '70%' }">
                    <h1 class="mb-0">WHAT WE BELIEVE</h1>
                    <div class="mouse">
                    <a href="#" class="mouse-icon">
                        <div class="mouse-wheel"><span class="fa fa-chevron-circle-down"></span></div>
                    </a>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'image'
        ],

        data() {
            return {
                fullheight: '0px'
            }
        },

        mounted() {
            this.fullheight = $(window).height() + 'px';

            this.getWindowHeight();

            this.$nextTick(function() {
                window.addEventListener('resize', this.getWindowHeight);

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

            getWindowHeight(event) {
                this.fullheight = $(window).height() + 'px';
            }
        }
    }
</script>