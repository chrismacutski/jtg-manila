<template>
    <div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <search-series :session-filters="sessionFilters"
                                    @hide-list="emptySeriesData"
                                    @filtered="setSeriesData"></search-series>
                </div>
            </div>
        </div>

        <div class="jtg-series-section pt-4">
            <div class="container">
                <div class="row">
                    <template v-if="series.count() > 0">
                        <div class="col-md-4 jtg-animate" :class="[shouldAnimate ? 'fadeInUp jtg-animated' : 'fadeInUp jtg-animated']" v-for="series in series">
                            <div class="jtg-series">
                                <a :href="'/series/' + series.hash_id" class="img popup-vimeo mb-3 d-flex justify-content-center align-items-center" :style="{ 'background-image': 'url(' + series.image_src + ')'}">
                                    <div class="icon d-flex justify-content-center align-items-center">
                                        <span class="icon-play"></span>
                                    </div>
                                </a>
                                <div class="text">
                                    <h3><a :href="'/series/' + series.hash_id">{{ series.name }}</a></h3>
                                    <span class="position">{{ getSermonDateFormat(series.happened_at) }}</span>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template v-if="showLoader">
                        <div class="col-md-12 mb-4">
                            <div class="card p-0">
                                <div class="card-body text-center">
                                    <i class="fa fa-spinner fa-spin fa-4x fa-fw"></i>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template v-if="showNoData">
                        <div class="col-md-12 mb-4">
                            <div class="card p-0">
                                <div class="card-body text-center">
                                    <h3>No Series found!</h3>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                <show-more-series @filtered="setSeriesData"></show-more-series>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['seriesList', 'sessionFilters'],

        data() {
            return {
                series: collect([]),

                shouldAnimate: false,

                showLoader: false,

                showNoData: false
            }
        },

        created() {
            if (this.seriesList.data.length == 0) {
                this.showNoData = true;
            }

            _.forEach(this.seriesList.data, (sermon) => {
                this.series.push(sermon);
            });
        },

        methods: {
            getSermonDateFormat(event) {
                return moment(event).format('LLLL');
//                let starting_at = moment(event.starting_at, 'YYYY-MM-DD');
//                let ending_at = moment(event.ending_at, 'YYYY-MM-DD');
//                if (starting_at == ending_at) {
//                    return moment(event.starting_at).format('MMMM DD') + ' @ ' + moment(event.starting_at).format('hh:ssa');
//                } else {
//                    return moment(event.starting_at).format('MMMM DD') + ' - ' + moment(event.ending_at).format('MMMM DD YYYY');
//                }
            },

            emptySeriesData() {
                this.showLoader = true;
                this.showNoData = false;

                this.$nextTick(()=>{
                    this.series = collect([]);
                })
            },

            setSeriesData(data) {
                this.showLoader = false;

                if (data.total == 0) {
                    this.showNoData = true;
                } else {
                    this.showNoData = false;
                }

                this.shouldAnimate = true;
                _.forEach(data.data, (event, index) => {
                    this.$set(this.series.items, index, event);
                });
            }
        }
    }
</script>