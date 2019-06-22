<template>
    <div class="container">
        <div class="row justify-content-center mt-5 mb-5 pb-3">
            <div class="col-md-12 text-center heading-section jtg-animate">
                <h2 class="mb-2"><span class="px-4">DEPARTMENTS</span></h2>
            </div>
        </div>
        <div class="row mb-5">

            <div class="col-md-6">
                <div class="card p-0 border-0 jtg-animate h-100 mb-5">
                    <div class="card-body p-0 text-center">
                        <h5 class="mb-5">ACTIVE MEN (AMEN)</h5>
                        <img v-lazy="'/images/amens.jpg'" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-0 border-0 jtg-animate h-100 mb-5">
                    <div class="card-body p-0 text-center">
                        <h5 class="mb-5">WOMEN OF MANILA EMPOWERING NATION (WOMEN)</h5>
                        <img v-lazy="'/images/womens.jpg'" class="img-fluid">

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-0 border-0 jtg-animate h-100 mb-5">
                    <div class="card-body p-0 text-center">
                        <h5 class="mb-5">IGNITED COUPLES</h5>
                        <img v-lazy="'/images/ignited-couples.jpg'" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-0 border-0 jtg-animate h-100 mb-5">
                    <div class="card-body p-0 text-center">
                        <h5 class="mb-5">BLAZING ACHIEVERS</h5>
                        <img v-lazy="'/images/blazing-achievers.png'" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-0 border-0 jtg-animate h-100 mb-5">
                    <div class="card-body p-0 text-center">
                        <h5 class="mb-5">YOUTH INVADERS</h5>
                        <img v-lazy="'/images/youth-invaders.jpg'" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-0 border-0 jtg-animate h-100 mb-5">
                    <div class="card-body p-0 text-center">
                        <h5 class="mb-5">MANILA KIDS FOR JESUS</h5>
                        <img v-lazy="'/images/kids.jpg'" class="img-fluid">
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