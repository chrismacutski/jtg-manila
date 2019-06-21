<template>
    <div class="jtg-map py-5" v-lazy:background-image="image">
        <div class="overlay"></div>
        <div class="container">
            <div class="row d-flex align-items-center">
                <div class="col-md-6 jtg-animate">
                    <div class="card rounded-0 pt-4 pb-4">
                        <div class="card-body text-center">
                            <h2>Service Hours and Locations</h2>
                            <h6>Sundays | 10:00 AM to 1:00 PM & 4:00 PM to 6:00 PM</h6>
                            <h6 class="pb-2">Thursdays | 7:00 PM to 9:00 PM</h6>

                            <h6 class="pb-2">1007 335 Zone 33 STA Cruz Manila, 1003, Rizal Ave, Santa Cruz, Maynila, 1008 Kalakhang Maynila</h6>
                            <a class="btn btn-primary px-4 py-2" target="_blank" href="https://www.google.com/maps/place/JTG+MANILA+CHURCH/@14.6065826,120.9818983,19.99z/data=!4m5!3m4!1s0x3397ca013563de8b:0xae0ac353f39b4d5d!8m2!3d14.6066601!4d120.9820092">GET DIRECTIONS</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'image'
        ]
    }
</script>