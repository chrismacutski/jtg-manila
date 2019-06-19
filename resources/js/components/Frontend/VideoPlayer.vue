<template>
    <div>
        <series-youtube-video :video-id="videoId"></series-youtube-video>
    </div>
</template>

<script>
    export default {
        props: ['videoUrl'],

        data() {
            return {
                videoId : this.$youtube.getIdFromURL(this.videoUrl)
            }
        },

        methods: {

        }
    }
</script>