<template>
    <div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <search-event :session-filters="sessionFilters"
                                  @hide-list="emptyEventData"
                                  @filtered="setEventData"></search-event>
                </div>
            </div>
        </div>

        <div class="jtg-event-section pt-4">
            <div class="container">
                <div class="row">
                    <template v-if="events.count() > 0">
                        <div class="col-md-4 d-flex jtg-animate" :class="[shouldAnimate ? 'fadeInUp jtg-animated' : 'fadeInUp jtg-animated']" v-for="event in events">
                            <div class="jtg-event-entry align-self-stretch">
                                <a :href="'/events/' + event.id" class="block-20" :style="{ 'background-image': 'url(' + event.image_src + ')'}"></a>
                                <div class="text p-4 d-block">
                                    <h3 class="heading mb-1 text-center">
                                        <a :href="'/events/' + event.hash_id">{{ event.name }}</a>
                                    </h3>
                                    <p class="time-loc text-center">
                                        <!--<h6 class="mr-2 font-weight-bold text-center">-->
                                        {{ getEventDateFormat(event) }}
                                        <br>

                                        <template v-if="event.address">
                                            <span class="small">{{ event.address }}</span>
                                        </template>
                                        <!--</h6>-->
                                    </p>
                                    <p>{{ event.description }}</p>
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
                                    <h3>No Events found!</h3>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                <show-more-events @filtered="setEventData"></show-more-events>
                <!--<div class="row mt-0">-->
                    <!--<div class="col text-center jtg-animate">-->
                        <!--<p><a href="#" class="btn btn-primary btn-outline-primary p-3">SHOW MORE</a></p>-->
                    <!--</div>-->
                <!--</div>-->
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['eventList', 'sessionFilters'],

        data() {
            return {
                events: collect([]),

                shouldAnimate: false,

                showLoader: false,

                showNoData: false
            }
        },

        created() {
            if (this.eventList.data.length == 0) {
                this.showNoData = true;
            }

            _.forEach(this.eventList.data, (event) => {
                this.events.push(event);
            });
        },

        methods: {
            getEventDateFormat(event) {
                let starting_at = moment(event.starting_at, 'YYYY-MM-DD');
                let ending_at = moment(event.ending_at, 'YYYY-MM-DD');
                if (starting_at == ending_at) {
                    return moment(event.starting_at).format('MMMM DD') + ' - ' + moment(event.ending_at).format('hh:ssa');
                } else {
                    return moment(event.starting_at).format('MMMM DD') + ' @ ' + moment(event.starting_at).format('hh:ssa') + ' - ' + moment(event.ending_at).format('hh:ssa');
                }
            },

            emptyEventData() {
                this.showLoader = true;
                this.showNoData = false;

                this.$nextTick(()=>{
                    this.events = collect([]);
                })
            },

            setEventData(data) {
                this.showLoader = false;

                if (data.total == 0) {
                    this.showNoData = true;
                } else {
                    this.showNoData = false;
                }

                this.shouldAnimate = true;
                _.forEach(data.data, (event, index) => {
                    this.$set(this.events.items, index, event);
                });
            }
        }
    }
</script>