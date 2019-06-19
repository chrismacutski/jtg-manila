<template>
    <div class="container">
        <form @submit.prevent="onCreate">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-darker text-white">
                            <h6 class="text-center text-white">NEW EVENT</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>NAME</label>
                                <input id="name"
                                       type="text"
                                       name="name"
                                       v-model="form.name"
                                       :class="[errors.name ? 'form-control is-invalid' : 'form-control']" />

                                <div :class="[errors.name ? 'invalid-feedback text-left' : '']">
                                    <template v-for="error in errors.name">{{ error }} <br></template>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>DESCRIPTION</label>
                                <textarea placeholder="Type in the short description of the event"
                                          v-model="form.description"
                                          cols="30"
                                          rows="3"
                                          :class="[errors.name ? 'form-control is-invalid' : 'form-control']"></textarea>

                                <div :class="[errors.description ? 'invalid-feedback text-left' : '']">
                                    <template v-for="error in errors.description">{{ error }} <br></template>
                                </div>
                                <!--<wysiwyg name="body"-->
                                         <!--v-model="form.description"-->
                                         <!--placeholder="Enter your Email Signature here"-->
                                         <!--:should-clear="false"></wysiwyg>-->

                                <!--<p class="text-danger small" v-if="errors.description">-->
                                    <!--<template v-for="error in errors.description">{{ error }}</template>-->
                                <!--</p>-->
                            </div>

                            <!--<div class="form-group">-->
                                <!--<label>CONTENT</label>-->
                                <!--<textarea placeholder="Type in the contents of the event"-->
                                          <!--v-model="form.content"-->
                                          <!--cols="30"-->
                                          <!--rows="6"-->
                                          <!--:class="[errors.name ? 'form-control is-invalid' : 'form-control']"></textarea>-->

                                <!--<div :class="[errors.content ? 'invalid-feedback text-left' : '']">-->
                                    <!--<template v-for="error in errors.content">{{ error }} <br></template>-->
                                <!--</div>-->
                                <!--&lt;!&ndash;<wysiwyg name="body"&ndash;&gt;-->
                                         <!--&lt;!&ndash;v-model="form.content"&ndash;&gt;-->
                                         <!--&lt;!&ndash;placeholder="Enter your Email Signature here"&ndash;&gt;-->
                                         <!--&lt;!&ndash;:should-clear="false"></wysiwyg>&ndash;&gt;-->

                                <!--&lt;!&ndash;<p class="text-danger small" v-if="errors.content">&ndash;&gt;-->
                                    <!--&lt;!&ndash;<template v-for="error in errors.content">{{ error }}</template>&ndash;&gt;-->
                                <!--&lt;!&ndash;</p>&ndash;&gt;-->
                            <!--</div>-->

                            <div class="form-group">
                                <label>ADDRESS</label>
                                <input id="address"
                                       type="text"
                                       name="address"
                                       v-model="form.address"
                                       :class="[errors.address ? 'form-control is-invalid' : 'form-control']" />

                                <div :class="[errors.address ? 'invalid-feedback text-left' : '']">
                                    <template v-for="error in errors.address">{{ error }} <br></template>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="d-flex justify-content-start">WILL START AT</label>
                                <flat-pickr v-model="form.starting_at"
                                            :config="dateConfig"
                                            :class="[errors.starting_at ? 'form-control is-invalid' : 'form-control']"></flat-pickr>

                                <div :class="[errors.starting_at ? 'invalid-feedback text-left' : '']">
                                    <template v-for="error in errors.starting_at">{{ error }}</template>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="d-flex justify-content-start">WILL END AT</label>
                                <flat-pickr v-model="form.ending_at"
                                            :config="dateConfig"
                                            :class="[errors.ending_at ? 'form-control is-invalid' : 'form-control']"></flat-pickr>

                                <div :class="[errors.ending_at ? 'invalid-feedback text-left' : '']">
                                    <template v-for="error in errors.ending_at">{{ error }}</template>
                                </div>
                            </div>


                            <div class="form-group">
                                <label>EVENT IMAGE</label>
                                <input type="file"
                                       ref="image_src"
                                       name="image_src"
                                       multiple
                                       :class="[errors.image_src ? 'form-control is-invalid' : 'form-control']">

                                <div :class="[errors.image_src ? 'invalid-feedback text-left' : '']">
                                    <template v-for="error in errors.image_src">{{ error }}</template>
                                </div>
                            </div>

                            <!--<div class="form-group">-->
                                <!--<label>THUMBNAIL IMAGE</label>-->
                                <!--<input type="file"-->
                                       <!--ref="image_thumbnail_src"-->
                                       <!--name="image_thumbnail_src"-->
                                       <!--multiple-->
                                       <!--:class="[errors.image_thumbnail_src ? 'form-control is-invalid' : 'form-control']">-->

                                <!--<div :class="[errors.image_thumbnail_src ? 'invalid-feedback text-left' : '']">-->
                                    <!--<template v-for="error in errors.image_thumbnail_src">{{ error }}</template>-->
                                <!--</div>-->
                            <!--</div>-->

                            <!--<div class="form-group">-->
                                <!--<label>AMOUNT <small class="text-info">Leave blank to set to default of 0.00</small></label>-->
                                <!--<input id="amount"-->
                                       <!--type="number"-->
                                       <!--name="amount"-->
                                       <!--v-model="form.amount"-->
                                       <!--:class="[errors.amount ? 'form-control is-invalid' : 'form-control']" />-->

                                <!--<div :class="[errors.amount ? 'invalid-feedback text-left' : '']">-->
                                    <!--<template v-for="error in errors.amount">{{ error }} <br></template>-->
                                <!--</div>-->
                            <!--</div>-->
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-darker text-white">
                            <h6 class="text-center text-white">CONTENT</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>HEADING</label>
                                <input id="header_text"
                                       type="text"
                                       name="header_text"
                                       v-model="form.header_text"
                                       :class="[errors.header_text ? 'form-control is-invalid' : 'form-control']" />

                                <div :class="[errors.header_text ? 'invalid-feedback text-left' : '']">
                                    <template v-for="error in errors.header_text">{{ error }} <br></template>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>CONTENT</label>
                                <textarea placeholder="Type in the contents of the event"
                                          v-model="form.text_content"
                                          cols="30"
                                          rows="6"
                                          :class="[errors.name ? 'form-control is-invalid' : 'form-control']"></textarea>

                                <div :class="[errors.text_content ? 'invalid-feedback text-left' : '']">
                                    <template v-for="error in errors.text_content">{{ error }} <br></template>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>YOUTUBE URL</label>
                                <input id="video_url"
                                       type="text"
                                       name="video_url"
                                       v-model="form.video_url"
                                       :class="[errors.video_url ? 'form-control is-invalid' : 'form-control']" />

                                <div :class="[errors.video_url ? 'invalid-feedback text-left' : '']">
                                    <template v-for="error in errors.video_url">{{ error }} <br></template>
                                </div>
                            </div>

                            <slider-attachments v-model="slider_images"></slider-attachments>
                            <div class="form-group">
                                <div class="d-flex justify-content-end">
                                    <button :disabled="disableCreateButton" type="submit" class="btn btn-primary" v-html="createButtonText"></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    import Wysiwyg from '../../components/Wysiwyg.vue';
    import SliderAttachments from '../../components/Event/Utils/SliderAttachments.vue';

    export default {
        components: {Wysiwyg, SliderAttachments},

        data () {
            return {
                form: {
                    name: '',
                    description : '',
//                    content: '',
                    address: '',
                    image_src: '',
                    image_thumbnail_src: '',
                    amount: '',
                    starting_at: '',
                    ending_at: '',
                    text_content: '',
                    video_url: '',
                },

                slider_images: [],

                errors : [],

                createButtonText: 'Create',

                dateConfig: {
                    wrap: true, // set wrap to true only when using 'input-group'
                    altFormat: 'M j, Y G:i K',
                    altInput: true,
                    dateFormat: 'Y-m-d H:i:S',
                    enableTime: true
                }
            }
        },

        mounted() {

        },

        watch: {
            'form.name'(newValue) {
                if (newValue != '') {
                    this.errors = _.omit(this.errors, 'name');
                }
            },

            'form.address'(newValue) {
                if (newValue != '') {
                    this.errors = _.omit(this.errors, 'address');
                }
            },

            'form.image_src'(newValue) {
                if (newValue != '') {
                    this.errors = _.omit(this.errors, 'image_src');
                }
            },

            'form.image_thumbnail_src'(newValue) {
                if (newValue != '') {
                    this.errors = _.omit(this.errors, 'image_thumbnail_src');
                }
            }
        },

        computed: {
            disableCreateButton() {
                if (this.createButtonText == 'Create') {
                    return false;
                }

                return true;
            },
        },

        methods: {
            onCreate() {
                this.createButtonText = '<i class="fa fa-spinner fa-spin fa-lg fa-fw"></i>';

                let params = new FormData();
                if (!_.isUndefined(this.$refs.image_src)) {
                    params.append('image_src', this.$refs.image_src.files[0]);
                }

                if (!_.isUndefined(this.$refs.image_thumbnail_src)) {
                    params.append('image_thumbnail_src', this.$refs.image_thumbnail_src.files[0]);
                }
                _.forEach(this.form, (item, index) => {
                    params.append(index, item);
                });

                _.forEach(this.slider_images, (item, index) => {
                    if (item != '') {
                        params.append('slider_images[' + index + ']', item);
                    }
                });

                axios.post(`/admin/events`, params)
                    .then(({data}) => {
                        console.log(data);
                        window.location.href = '/admin/events';
                    }).catch(error => {
                    if (error.response.data.errors) {
                        this.errors = error.response.data.errors;
                    }

                    this.createButtonText = 'Create';
                });
            }
        }
    }
</script>