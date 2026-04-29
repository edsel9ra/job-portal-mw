<template>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Nueva Oferta Laboral</h1>

        <JobForm v-if="!loading" :model-value="initial" :branches="branches" submit-text="Crear"
            :autosave-enabled="false" :on-submit="create" />
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import JobForm from '../components/JobForm.vue'
import { http } from '../lib/http'

const loading = ref(true)
const branches = ref([])

const initial = {
    name_job: '',
    description: '',
    salary: '',
    status: '',
    contract_type: '',
    branch_id: '',
}

onMounted(async () => {
    const { data } = await http.get('/branches')
    branches.value = data
    loading.value = false
})

async function create(payload) {
    await http.post('/jobs', payload)
    window.location.href = '/ofertas' // redirige al listado después de crear
}
</script>