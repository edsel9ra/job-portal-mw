<template>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Editar Oferta Laboral</h1>

        <JobForm v-if="!loading && job" :model-value="job" :branches="branches" submit-text="Actualizar"
            :autosave-enabled="true" :on-submit="update" />

    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { http } from '../lib/http'
import JobForm from '../components/JobForm.vue'

const route = useRoute()
const router = useRouter()

const id = Number(route.params.id)

const loading = ref(true)
const job = ref(null)
const branches = ref([])

if (!Number.isFinite(id)) {
    alert('ID inválido')
    router.push('/')
}

onMounted(async () => {
    try {
        const [b, j] = await Promise.all([
            http.get('branches'),
            http.get(`jobs/${id}`),
        ])
        branches.value = b.data
        job.value = j.data
    } finally {
        loading.value = false
    }
})

async function update(payload, opts = {}) {
  const res = await http.put(`jobs/${id}`, payload)

  // 👇 si tu backend devuelve { data: {...} }, esto lo normaliza
  const body = res.data?.data ?? res.data

  // ✅ Merge: evita que una respuesta parcial borre campos
  if (body && typeof body === 'object' && Object.keys(body).length) {
    job.value = { ...job.value, ...body }
  }

  if (!opts.silent) router.push('/')
}
</script>