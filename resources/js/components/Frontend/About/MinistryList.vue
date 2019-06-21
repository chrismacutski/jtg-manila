<template>
    <div class="container">
        <div class="row justify-content-center mt-5 mb-5 pb-3">
            <div class="col-md-12 text-center heading-section jtg-animate">
                <h2 class="mb-2"><span class="px-4">MINISTRIES</span></h2>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-md-6">
                <div class="card p-0 border-0 jtg-animate h-100 mb-5">
                    <div class="card-body p-0 text-center">
                        <h2 class="mb-5">Manila Media Ministry (M3)</h2>
                        <img v-lazy="'/images/m3.jpg'" class="img-fluid">

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-0 border-0 jtg-animate h-100 mb-5">
                    <div class="card-body p-0 text-center">
                        <h2 class="mb-5">Technical Team</h2>
                        <img v-lazy="'/images/technical.png'" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-0 border-0 jtg-animate h-100 mb-5">
                    <div class="card-body p-0 text-center">
                        <h2 class="mb-5">Manila’s Finest Production (MFP)</h2>
                        <img v-lazy="'/images/mif.jpg'" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-0 border-0 jtg-animate h-100 mb-5">
                    <div class="card-body p-0 text-center">
                        <h2 class="mb-5">WOW Team</h2>
                        <img v-lazy="'/images/wow.png'" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-0 border-0 jtg-animate h-100 mb-5">
                    <div class="card-body p-0 text-center">
                        <h2 class="mb-5">Gospel Band</h2>
                        <img v-lazy="'/images/gospel-band.png'" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-0 border-0 jtg-animate h-100 mb-5">
                    <div class="card-body p-0 text-center">
                        <h2 class="mb-5">50 Heroes</h2>
                        <img v-lazy="'/images/50-heroes.jpg'" class="img-fluid">
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