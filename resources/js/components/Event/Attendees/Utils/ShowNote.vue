<template>
    <div>
        <button class="btn btn-sm mr-1" @click="showModal">
            <i class="fa fa-eye fa-lg"></i>
        </button>

        <sweet-modal width="100%" ref="modal" modal-theme="light" overlay-theme="light">
            <strong>Message</strong>
            <br/><br/>

            <p class="text-justify" style="white-space: pre-line">{{ message }}</p>
        </sweet-modal>
    </div>
</template>

<script>
    export default {
        props: ['message'],

        data() {
            return {

            }
        },

        methods: {
            showModal() {
                this.$refs.modal.open();
            }
        }
    }
</script>