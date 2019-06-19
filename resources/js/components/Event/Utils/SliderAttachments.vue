<template>
    <div>
        <label>SLIDER IMAGES</label>

        <fields :data="slider_images"
                @reloaded-attachments="reload"></fields>

        <button type="button" class="btn btn-link btn-sm" @click="slider_images.push('')">Add Another</button>
    </div>
</template>

<script>
    import Fields from './Attachments/Fields.vue'

    export default {
        components: { Fields },

        data() {
            return {
                slider_images: []
            }
        },

        created() {
            this.slider_images[0] = '';
        },

        methods: {
            reload(data) {
                this.slider_images = data;

                this.$emit('input', this.slider_images);
            }
        }
    }
</script>