<template>
    <div class="space-y-3">
        <!-- Banner cambios -->
        <div v-if="dirty"
            class="border rounded-xl p-3 bg-yellow-50 text-yellow-900 text-sm flex items-center justify-between">
            <span>⚠️ Tienes cambios sin guardar.</span>
            <span v-if="autosaveEnabled" class="text-xs text-yellow-800">
                {{ saving ? 'Guardando...' : 'Autosave activado' }}
            </span>
        </div>

        <form class="space-y-3" @submit.prevent="manualSubmit">
            <div>
                <label class="block mb-1">Nombre del cargo</label>
                <input class="border rounded p-2 w-full" v-model="form.name_job" />
                <p v-if="errors.name_job" class="text-red-600 text-sm">{{ errors.name_job[0] }}</p>
            </div>

            <div>
                <label class="block mb-1">Descripción</label>
                <textarea class="border rounded p-2 w-full" rows="4" v-model="form.description"></textarea>
                <p v-if="errors.description" class="text-red-600 text-sm">{{ errors.description[0] }}</p>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block mb-1">Salario</label>
                    <input type="number" step="0.01" class="border rounded p-2 w-full" v-model="form.salary" />
                    <p v-if="errors.salary" class="text-red-600 text-sm">{{ errors.salary[0] }}</p>
                </div>

                <div>
                    <label class="block mb-1">Estado</label>
                    <select class="border rounded p-2 w-full" v-model="form.status">
                        <option disabled value="">Seleccione...</option>
                        <option v-for="s in STATUS" :key="s" :value="s">{{ s }}</option>
                    </select>
                    <p v-if="errors.status" class="text-red-600 text-sm">{{ errors.status[0] }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block mb-1">Tipo de contrato</label>
                    <select class="border rounded p-2 w-full" v-model="form.contract_type">
                        <option disabled value="">Seleccione...</option>
                        <option v-for="c in CONTRACTS" :key="c" :value="c">{{ c }}</option>
                    </select>
                    <p v-if="errors.contract_type" class="text-red-600 text-sm">{{ errors.contract_type[0] }}</p>
                </div>

                <div>
                    <label class="block mb-1">Sucursal</label>
                    <select class="border rounded p-2 w-full" v-model.number="form.branch_id">
                        <option disabled value="">Seleccione...</option>
                        <option v-for="b in branches" :key="b.id" :value="b.id">
                            {{ b.name }}
                        </option>
                    </select>
                    <p v-if="errors.branch_id" class="text-red-600 text-sm">{{ errors.branch_id[0] }}</p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <button type="button" class="px-4 py-2 border rounded-lg hover:bg-gray-50" @click="$router.push('/')">
                    ← Volver al listado
                </button>

                <button class="px-4 py-2 rounded bg-black text-white" :disabled="submitting || saving">
                    {{ submitText }}
                </button>

                <button v-if="autosaveEnabled" type="button" class="px-4 py-2 rounded border hover:bg-gray-50"
                    :disabled="saving || !dirty" @click="saveNow">
                    Guardar ahora
                </button>

                <span v-if="lastSavedAt" class="text-xs text-gray-500">
                    Último guardado: {{ lastSavedAt }}
                </span>
            </div>
        </form>
    </div>
</template>

<script setup>
import { onBeforeUnmount, reactive, ref, watch } from 'vue'

const STATUS = ['Abierta', 'Pausada', 'Cerrada']
const CONTRACTS = [
    'Término Fijo',
    'Término Indefinido',
    'Obra o Labor',
    'Aprendizaje',
    'Ocasional',
    'Prestación de Servicios',
]

const props = defineProps({
    modelValue: { type: Object, default: () => ({}) },
    branches: { type: Array, default: () => [] },
    submitText: { type: String, default: 'Guardar' },

    // Debe guardar en backend. Para Create hará POST. Para Edit hará PUT.
    onSubmit: { type: Function, required: true },

    // Activa autosave (solo en Edit)
    autosaveEnabled: { type: Boolean, default: false },
})

const form = reactive({
    name_job: '',
    description: '',
    salary: '',
    status: '',
    contract_type: '',
    branch_id: '',
})

const errors = ref({})
const submitting = ref(false)

// Autosave state
const dirty = ref(false)
const saving = ref(false)
const lastSavedAt = ref('')
let savedSnapshot = ''
const hydrated = ref(false)
let autosaveTimer = null

function snapshot(obj) {
    // estable para comparar
    return JSON.stringify({
        name_job: obj.name_job ?? '',
        description: obj.description ?? '',
        salary: obj.salary ?? '',
        status: obj.status ?? '',
        contract_type: obj.contract_type ?? '',
        branch_id: obj.branch_id ?? '',
    })
}

function applyModel(v) {
  if (!v || typeof v !== 'object') return
  if (Object.keys(v).length === 0) return

  clearTimeout(autosaveTimer)

  const keys = ['name_job', 'description', 'salary', 'status', 'contract_type', 'branch_id']

  for (const k of keys) {
    // ✅ solo pisa si el backend envió la llave
    if (Object.prototype.hasOwnProperty.call(v, k)) {
      form[k] = v[k] ?? ''
    }
  }

  savedSnapshot = snapshot(form)
  dirty.value = false
  hydrated.value = true
}

watch(
    () => props.modelValue,
    (v) => applyModel(v),
    { immediate: true }
)

// Detecta cambios y programa autosave
watch(
  () => snapshot(form),
  (curr) => {
    dirty.value = curr !== savedSnapshot

    if (!props.autosaveEnabled) return
    if (!hydrated.value) return          // ✅ no autosave antes de hidratar
    if (!props.modelValue?.id) return    // ✅ edit real

    clearTimeout(autosaveTimer)
    if (!dirty.value) return

    autosaveTimer = setTimeout(() => saveNow(), 15000)
  }
)

async function saveNow() {
    if (!props.autosaveEnabled) return
    if (!dirty.value) return
    saving.value = true
    try {
        await props.onSubmit({ ...form }, { silent: true }) // le pasamos un flag opcional
        savedSnapshot = snapshot(form)
        dirty.value = false
        lastSavedAt.value = new Date().toLocaleTimeString('es-CO', { hour: '2-digit', minute: '2-digit' })
    } catch (e) {
        if (e?.response?.status === 422) errors.value = e.response.data.errors || {}
    } finally {
        saving.value = false
    }
}

// Submit manual (botón)
async function manualSubmit() {
    errors.value = {}
    submitting.value = true
    try {
        await props.onSubmit({ ...form })
        savedSnapshot = snapshot(form)
        dirty.value = false
        lastSavedAt.value = new Date().toLocaleTimeString('es-CO', { hour: '2-digit', minute: '2-digit' })
    } catch (e) {
        if (e?.response?.status === 422) errors.value = e.response.data.errors || {}
        else alert(`Error inesperado (${e?.response?.status ?? '??'})`)
    } finally {
        submitting.value = false
    }
}

// Protege salida si hay cambios sin guardar
function beforeUnload(e) {
    if (!dirty.value) return
    e.preventDefault()
    e.returnValue = ''
}
window.addEventListener('beforeunload', beforeUnload)

onBeforeUnmount(() => {
    window.removeEventListener('beforeunload', beforeUnload)
    clearTimeout(autosaveTimer)
})

onBeforeUnmount(() => {
    // doble seguridad (por si vue remonta)
})
</script>