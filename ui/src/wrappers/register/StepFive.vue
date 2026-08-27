<template>
    <div class="step">
        <Row center>
            <svg width="156" height="142" viewBox="0 0 156 142" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g filter="url(#filter0_d_6827_251669)">
                    <rect x="3.72266" y="77.6533" width="118.72" height="50.88" rx="5.65333" fill="white"/>
                    <path d="M53.999 103.175L61.1728 110.348L75.5456 96.0009" stroke="#5542F6" stroke-width="5.06979" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M131.751 96.0262H119.616V111.573L132.75 98.4389C133.641 97.5485 133.01 96.0262 131.751 96.0262Z" fill="white"/>
                    <path d="M43.2969 103.093H29.1635" stroke="#5542F6" stroke-width="2.82667" stroke-linecap="round"/>
                    <path d="M85.6963 103.093H99.8296" stroke="#5542F6" stroke-width="2.82667" stroke-linecap="round"/>
                    <path d="M31.9902 117.226L43.2969 110.16" stroke="#5542F6" stroke-width="2.82667" stroke-linecap="round"/>
                    <path d="M97.0039 117.226L85.6972 110.16" stroke="#5542F6" stroke-width="2.82667" stroke-linecap="round"/>
                    <path d="M31.9902 88.9594L43.2969 96.0261" stroke="#5542F6" stroke-width="2.82667" stroke-linecap="round"/>
                    <path d="M97.0039 88.9594L85.6972 96.0261" stroke="#5542F6" stroke-width="2.82667" stroke-linecap="round"/>
                </g>
                <g filter="url(#filter1_d_6827_251669)">
                    <rect x="23.2256" y="18.7068" width="118.72" height="50.88" rx="5.65333" fill="white"/>
                    <rect x="34.5322" y="41.3191" width="96.1067" height="5.65333" rx="2" fill="#5542F6"/>
                    <rect x="34.5322" y="52.627" width="96.1067" height="5.65333" rx="2" fill="#5542F6"/>
                    <rect x="34.5322" y="30.013" width="57.9467" height="5.65333" rx="2" fill="#5542F6"/>
                    <path d="M151.254 30.013H139.119V45.5596L152.253 32.4257C153.143 31.5353 152.513 30.013 151.254 30.013Z" fill="white"/>
                </g>
                <defs>
                    <filter id="filter0_d_6827_251669" x="0.89599" y="76.2399" width="135.098" height="56.5333" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                        <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                        <feOffset dy="1.41333"/>
                        <feGaussianBlur stdDeviation="1.41333"/>
                        <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0.0887805 0 0 0 0 0.35 0 0 0 0.06 0"/>
                        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_6827_251669"/>
                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_6827_251669" result="shape"/>
                    </filter>
                    <filter id="filter1_d_6827_251669" x="20.3989" y="17.2935" width="135.098" height="56.5333" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                        <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                        <feOffset dy="1.41333"/>
                        <feGaussianBlur stdDeviation="1.41333"/>
                        <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0.0887805 0 0 0 0 0.35 0 0 0 0.06 0"/>
                        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_6827_251669"/>
                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_6827_251669" result="shape"/>
                    </filter>
                </defs>
            </svg>
        </Row>
        <Row center>
            <H2 bold>Congratulations 🎉</H2>
        </Row>
        <Row class="thirty" center>
            <P large gray center>your account has successfully <br/> been created.</P>
        </Row>
    </div>
</template>

<script>
import _ from 'lodash';

export default {
    props: {},
    data(){
        return{
        }
    },
    computed: {
        user(){
            return window.store.auth.single;
        }
    },
    methods: {
    },
    created() {
    },
    mounted() {
    }
}
</script>

<style lang="scss" scoped>
@import "/src/assets/variables.scss";
.step{
    .thirty{
        margin-bottom: 30px;
    }
}
</style>