<template>
    <div>
        <p>
            <button @click="showModal" type="button" class="btn btn-history p-0">
                <i class="fa fa-play-circle-o fa-4x"></i>
            </button>

            <sweet-modal width="100%" ref="modal" modal-theme="dark" overlay-theme="dark" class="sModalHistory">
                <strong>History</strong>
                <br/><br/>

                <template v-if="windowWidth != ''">
                    <series-youtube-video :video-id="'hG-PQSoeBNc'"
                                          :player-width="windowWidth"
                                          :player-height="windowHeight"></series-youtube-video>
                </template>
            </sweet-modal>
        </p>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                windowWidth: '',
                windowHeight: ''
            }
        },

        methods: {
            showModal() {
                this.$refs.modal.open();
            }
        }
    }
</script>