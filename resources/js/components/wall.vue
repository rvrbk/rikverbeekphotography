<template>
    <div class="wall">
        <ul>
            <li v-for="picture in pictures" :key="picture.id">
                <img v-bind:src="'./api/picture?path=' + picture.path_display">
            </li>
        </ul>
    </div>
</template>

<script>
    
    export default {
        data() {
            return {
                pictures: []
            }
        },
        mounted() {
            const scope = this;

            axios.get('./api/pictures').then((response) => {
                scope.pictures = response.data.entries;
                console.log(scope.pictures);
            });
        }
    }

</script>