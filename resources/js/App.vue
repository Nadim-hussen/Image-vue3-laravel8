<template>
    <div>
        <h1>Upload image</h1>
        <p v-if="success.value == true">Successfully inserted</p>
        <form enctype="multipart/form-data" @submit="submit">
            <input type="file" @change="onChange" />
            <button type="submit"> submit</button>
        </form>

        <div v-for="paths in img" :key="paths.id">
             <img class="image" :src="`storage/uploads/${paths.name}`" alt="image">
        </div>
    </div>
</template>
<script>
import { onMounted, ref } from 'vue';
export default {
    setup() {
        const file = ref('')
        const img = ref([])
        const success = ref(false)
        const onChange = (e)=>{
            file.value = e.target.files[0];
        }
        const submit = (e) =>{
            e.preventDefault();
            const config ={
                headers:{
                    'content-type' : 'multipart/form-data'
                }
            }
            let data = new FormData();
            data.append('file',file.value);
            axios.post('/api/upload',data,config)
            .then((res)=>{
                file.value = '';
                success.value = true;
                 getImage();
            }).catch((err)=>{
                console.log(err)
            });
        }
        onMounted(()=>{
            getImage();
        })
        const getImage = async () =>{
            let response  = await axios.get('/api/getImg');
            console.log(response.data.length)
            img.value = response.data


        }
        return{
            submit,
            onChange,
            file,
            success,
            getImage,
            img
        }
    },
}
</script>
<style scoped>
.image{
    margin-top: 10px;
    height: 400px;
    width: 25vw;
}
</style>