<template>
    <div class="avatar-wrapper">
        <div class="avatar" :style="{'background-image':'url('+image+')'}" />
    </div>
</template>

<script>

export default {
    props: {},
    data() {
        return {
            avatar: {
                topType: ["NoHair", "Eyepatch", "Hat", "Hijab", "Turban", "WinterHat1", "WinterHat2", "WinterHat3", "WinterHat4", "LongHairBigHair", "LongHairBob", "LongHairBun", "LongHairCurly", "LongHairCurvy", "LongHairDreads", "LongHairFrida", "LongHairFro", "LongHairFroBand", "LongHairNotTooLong", "LongHairShavedSides", "LongHairMiaWallace", "LongHairStraight", "LongHairStraight2", "LongHairStraightStrand", "ShortHairDreads01", "ShortHairDreads02", "ShortHairFrizzle", "ShortHairShaggyMullet", "ShortHairShortCurly", "ShortHairShortFlat", "ShortHairShortRound", "ShortHairShortWaved", "ShortHairSides", "ShortHairTheCaesar", "ShortHairTheCaesarSidePart"],
                accessoriesType: ["Blank", "Kurt", "Prescription01", "Prescription02", "Round", "Sunglasses", "Wayfarers"],
                hairColor: ["Auburn", "Black", "Blonde", "BlondeGolden", "Brown", "BrownDark", "PastelPink", "Blue", "Platinum", "Red", "SilverGray"],
                hatColor: ["Black", "Blue01", "Blue02", "Blue03", "Gray01", "Gray02", "Heather", "PastelBlue", "PastelGreen", "PastelOrange", "PastelRed", "PastelYellow", "Pink", "Red", "White"],
                facialHairType: ["Blank", "BeardMedium", "BeardLight", "BeardMajestic", "MoustacheFancy", "MoustacheMagnum"],
                facialHairColor: ["Auburn", "Black", "Blonde", "BlondeGolden", "Brown", "BrownDark", "Platinum", "Red"],
                clotheType: ["BlazerShirt", "BlazerSweater", "CollarSweater", "GraphicShirt", "Hoodie", "Overall", "ShirtCrewNeck", "ShirtScoopNeck", "ShirtVNeck"],
                clotheColor: ["Black", "Blue01", "Blue02", "Blue03", "Gray01", "Gray02", "Heather", "PastelBlue", "PastelGreen", "PastelOrange", "PastelRed", "PastelYellow", "Pink", "Red", "White"],
                graphicType: ["Bat", "Cumbia", "Deer", "Diamond", "Hola", "Pizza", "Resist", "Selena", "Bear", "SkullOutline", "Skull"],
                eyeType: ["Close", "Cry", "Default", "Dizzy", "EyeRoll", "Happy", "Hearts", "Side", "Squint", "Surprised", "Wink", "WinkWacky"],
                eyebrowType: ["Angry", "AngryNatural", "Default", "DefaultNatural", "FlatNatural", "RaisedExcited", "RaisedExcitedNatural", "SadConcerned", "SadConcernedNatural", "UnibrowNatural", "UpDown", "UpDownNatural"],
                mouthType: ["Concerned", "Default", "Disbelief", "Eating", "Grimace", "Sad", "ScreamOpen", "Serious", "Smile", "Tongue", "Twinkle", "Vomit"],
                skinColor: ["Tanned", "Yellow", "Pale", "Light", "Brown", "DarkBrown", "Black"],
            }
        }
    },
    watch: {
        user() {
            this.$forceUpdate();
        },
    },
    computed: {
        image: {
            get(){
                if(this.user && this.user.image !== null){
                    return 'https://'+this.user.image;
                } else {
                    return 'https://avataaars.io/?avatarStyle=Transparent&'+this.avatarString();
                }
            }
        },
        user: {
            get() {
                return window.store.auth.single;
            }
        },
    },
    methods: {
        avatarString() {
            let letter = 'A';
            if (this.user && this.user.first_name && this.user.last_name) {
                letter = (this.user.first_name[0].toLowerCase().charCodeAt(0) - 96) + (this.user.last_name[0].toLowerCase().charCodeAt(0) - 96)
            }
            let strings = []
            for (let key in this.avatar) {
                let corrected = (letter * (strings.length + 2)) % this.avatar[key].length
                strings.push(key + '=' + this.avatar[key][corrected]);
            }
            return strings.join('&');
        }
    },
    created() {
    },
    mounted() {
    }
}
</script>

<style lang="scss" scoped>
@import "/src/assets/variables.scss";
.avatar-wrapper{
    position: relative;
    width: 100%;
    height: 100%;

    .avatar{
        width: 100%;
        background-size: cover;
        border-radius: 100%;
        height: 110%;
        position: absolute;
        top: -10%;
        background-position: center;
    }
}


</style>