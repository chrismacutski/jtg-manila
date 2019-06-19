<template>
    <sweet-modal width="100%" ref="modal" modal-theme="dark" overlay-theme="dark" class="sModalHistory">
        <strong>History</strong>
        <br/><br/>

        <template v-if="windowWidth != ''">
            <series-youtube-video :video-id="'hG-PQSoeBNc'"
                                  :player-width="windowWidth"
                                  :player-height="windowHeight"></series-youtube-video>
        </template>
    </sweet-modal>
</template>

<style>
    .sModalHistory {
        z-index: 12 !important;
    }
</style>

<script>
    export default {
        data() {
            return {
                windowWidth: '',
                windowHeight: ''
            }
        },

        mounted() {
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

            getWindowWidth(event) {
                this.windowWidth = document.documentElement.clientWidth - 100;
            },

            getWindowHeight(event) {
                this.windowHeight = document.documentElement.clientHeight - 200;
            }
        }

    }
</script>