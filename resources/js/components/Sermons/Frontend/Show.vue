<template>
    <div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 bg-gray">
                    <div class="jtg-vision">
                        <div class="container">
                            <div class="row justify-content-center my-5" ref="content_details">
                                <div class="col-md-8 py-lg-3 px-lg-5 bg-darker">
                                    <h3 class="d-flex justify-content-end align-items-center jtg-animate">
                                        <button @click="showNotes = !showNotes" type="button" class="btn btn-primary py-3 px-4 text-white" v-if="sermon.notes.length" v-html="showNotesText"></button>
                                    </h3>
                                    <h3 class="jtg-animate d-flex justify-content-between" style="text-transform: uppercase">
                                        {{ sermon.name }}
                                        <div>
                                        </div>
                                    </h3>
                                    <p class="jtg-animate text-justify" style="white-space: pre-line" v-html="sermon.content">
                                    </p>

                                    <a v-if="sermon.file_src" :href="sermon.file_src" target="_blank" class="btn btn-transparent py-3 px-4 jtg-animate d-flex justify-content-center">DOWNLOAD MESSAGE</a>
                                </div>
                                <transition name="notes" mode="out-in">
                                    <div :style="{ 'min-height': notes_height + ' px'}" class="col-md-4 p-5" v-if="!showNotes">
                                        <div class="block-21 mb-4 d-flex">
                                            <div class="text">
                                                <h3 class="heading"><a href="#">SPEAKER</a></h3>
                                                <div class="meta">
                                                    <div><a href="#"><span class="icon-person"></span> {{ sermon.speaker.fullname }}</a></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="block-21 mb-4 d-flex">
                                            <div class="text">
                                                <h3 class="heading"><a href="#">DATE</a></h3>
                                                <div class="meta">
                                                    <div><a href="#"><span class="icon-calendar"></span> {{ getSermonDateFormat(sermon.happened_at) }}</a></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </transition>
                                <transition name="details" mode="in-out">
                                    <div :style="{ 'min-height': notes_height + ' px'}" class="col-md-4 p-0" v-if="showNotes">
                                        <div class="card p-0 rounded-0 border-0 bg-darker">
                                            <div class="card-header">
                                                <h2 class="text-white">NOTES</h2>
                                            </div>
                                            <div class="card-body bg-darker-light text-white mb-4" v-for="note in sermon.notes">
                                                <span v-html="note.body"></span>
                                            </div>
                                        </div>
                                    </div>
                                </transition>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
    .notes-enter, .notes-leave-to {
        opacity: 0;
        transform: rotateY(90deg);
    }

    .notes-enter-active, .notes-leave-active {
        transition: all 0.5s;
    }

    .details-enter, .details-leave-to {
        opacity: 0;
        transform: rotateY(90deg);
    }

    .details-enter-active, .details-leave-active {
        transition: all 0.5s;
    }
</style>

<script>
    export default {

        props: ['sermon'],

        data() {
            return {
                showNotes: false,

                notes_height: '',

                showNotesText: 'SHOW NOTES'
            }
        },

        watch: {
            'showNotes'(newValue) {
                if (newValue) {
                    this.$nextTick(() => {
                        this.notes_height = this.$refs.content_details.offsetHeight;
                    })

                    this.showNotesText = 'HIDE NOTES';
                } else {
                    this.showNotesText = 'SHOW NOTES';
                }
            }
        },

        methods: {
            getSermonDateFormat(happened_at) {
                return moment(happened_at).format('LLLL');
//                let starting_at = moment(event.starting_at, 'YYYY-MM-DD');
//                let ending_at = moment(event.ending_at, 'YYYY-MM-DD');
//                if (starting_at == ending_at) {
//                    return moment(event.starting_at).format('MMMM DD') + ' @ ' + moment(event.starting_at).format('hh:ssa');
//                } else {
//                    return moment(event.starting_at).format('MMMM DD') + ' - ' + moment(event.ending_at).format('MMMM DD YYYY');
//                }
            }
        }
    }
</script>