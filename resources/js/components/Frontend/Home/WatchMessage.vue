<template>
    <div>
        <p class="mt-4 btn-customize">
            <button @click="showModal" type="button" class="btn btn-transparent px-4 py-2 mr-md-2 popup-vimeo">
                <span class="icon-play"></span> WATCH MESSAGE
            </button>
        </p>

        <sweet-modal width="100%" ref="modal" modal-theme="dark" overlay-theme="dark" @close="closeModal" class="sModalMsg">
            <strong>Heartbeat | When Jesus' Heartbeat Stops...</strong>
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
    .sModalMsg {
        z-index: 12 !important;
    }
</style>

<script>
    export default {
        data() {
            return {
                modal_title: '',

                windowWidth: '',
                windowHeight: '',

                errors: []
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
                this.modal_title = `Heartbeat`;
                this.$refs.modal.open();
            },

            closeModal() {
                this.clearForm();
            },

            clearForm() {
                this.modal_title = '';

                this.errors = [];
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