<template>
    <div class="space-y-6">
        <!-- Cambios sin guardar -->
        <Message v-if="isDirty" :pt="ptMessage" severity="warn" :closable="false"
            class="!rounded-2xl !border !border-amber-200 !bg-amber-50 !text-amber-800">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-100 text-amber-700">
                        <span class="material-symbols-outlined text-[20px]">warning</span>
                    </div>

                    <div>
                        <p class="text-sm font-black">
                            Cambios sin guardar
                        </p>

                        <p class="text-xs text-amber-700">
                            Recuerda guardar la información antes de salir.
                        </p>
                    </div>
                </div>

                <span v-if="autosaving"
                    class="inline-flex w-fit items-center rounded-full bg-white px-3 py-1 text-xs font-bold text-amber-700 ring-1 ring-amber-200">
                    Autoguardando…
                </span>
            </div>
        </Message>

        <form class="space-y-6" @submit.prevent="submit(false)">
            <!-- Datos de la oferta -->
            <Card :pt="ptCard">
                <template #content>
                    <div class="overflow-hidden rounded-[2rem]">
                        <div class="border-b border-slate-100 bg-slate-50 px-6 py-5">
                            <div class="flex items-start gap-4">
                                <div
                                    class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-red-50 text-red-600">
                                    <span class="material-symbols-outlined">work</span>
                                </div>

                                <div>
                                    <p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                                        Datos de la oferta
                                    </p>

                                    <h3 class="mt-2 text-xl font-black text-slate-950">
                                        Información principal
                                    </h3>

                                    <p class="mt-1 text-sm leading-6 text-slate-500">
                                        Define el nombre de la vacante, la sede y la descripción que verá el candidato.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-5 p-6">
                            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                                <!-- Nombre -->
                                <div>
                                    <label class="mb-2 block text-sm font-black text-slate-800">
                                        Nombre de la oferta
                                    </label>

                                    <div class="relative">
                                        <div
                                            class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-slate-400">
                                            <span class="material-symbols-outlined text-[18px]">badge</span>
                                        </div>

                                        <InputText v-model="form.name_job" :pt="ptInputText"
                                            :invalid="hasErr('name_job')"
                                            class="!w-full !rounded-2xl !border-slate-200 !bg-slate-50 !py-3 !pl-12 !pr-4 !text-sm !text-slate-800 !shadow-sm placeholder:!text-slate-400 focus:!border-red-500 focus:!bg-white focus:!ring-4 focus:!ring-red-500/20"
                                            placeholder="Ej: Auxiliar de cocina" />
                                    </div>

                                    <p v-if="hasErr('name_job')" class="mt-2 text-xs font-semibold text-red-600">
                                        {{ firstErr('name_job') }}
                                    </p>
                                </div>

                                <!-- Sede -->
                                <div>
                                    <label class="mb-2 block text-sm font-black text-slate-800">
                                        Sede
                                    </label>

                                    <Select v-model="form.branch_id" :pt="ptSelect" :invalid="hasErr('branch_id')"
                                        :options="branchOptions" optionLabel="label" optionValue="value"
                                        placeholder="Selecciona una sede…" class="!w-full !rounded-2xl" />

                                    <p v-if="hasErr('branch_id')" class="mt-2 text-xs font-semibold text-red-600">
                                        {{ firstErr('branch_id') }}
                                    </p>
                                </div>
                            </div>

                            <!-- Descripción -->
                            <div>
                                <label class="mb-2 block text-sm font-black text-slate-800">
                                    Descripción
                                </label>

                                <Textarea v-model="form.description" :pt="ptTextarea" :invalid="hasErr('description')"
                                    autoResize :rows="6"
                                    class="!w-full !rounded-2xl !border-slate-200 !bg-slate-50 !px-4 !py-3 !text-sm !leading-6 !text-slate-800 !shadow-sm placeholder:!text-slate-400 focus:!border-red-500 focus:!bg-white focus:!ring-4 focus:!ring-red-500/20"
                                    placeholder="Funciones principales, requisitos, beneficios, horarios o información importante de la oferta…" />

                                <div class="mt-2 flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                                    <p v-if="hasErr('description')" class="text-xs font-semibold text-red-600">
                                        {{ firstErr('description') }}
                                    </p>

                                    <p class="text-xs text-slate-400">
                                        Describe la vacante de forma clara para mejorar la calidad de las aplicaciones.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </Card>

            <!-- Condiciones -->
            <Card :pt="ptCard">
                <template #content>
                    <div class="overflow-hidden rounded-[2rem]">
                        <div class="border-b border-slate-100 bg-slate-50 px-6 py-5">
                            <div class="flex items-start gap-4">
                                <div
                                    class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-red-50 text-red-600">
                                    <span class="material-symbols-outlined">payments</span>
                                </div>

                                <div>
                                    <p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                                        Condiciones
                                    </p>

                                    <h3 class="mt-2 text-xl font-black text-slate-950">
                                        Salario, estado y contrato
                                    </h3>

                                    <p class="mt-1 text-sm leading-6 text-slate-500">
                                        Configura las condiciones principales de la vacante.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-3">
                            <!-- Salario -->
                            <div>
                                <label class="mb-2 block text-sm font-black text-slate-800">
                                    Salario
                                </label>

                                <InputNumber v-model="form.salary" :pt="ptInputNumber" :invalid="hasErr('salary')"
                                    :min="0" :useGrouping="true" placeholder="0" />

                                <p v-if="hasErr('salary')" class="mt-2 text-xs font-semibold text-red-600">
                                    {{ firstErr('salary') }}
                                </p>
                            </div>

                            <!-- Estado -->
                            <div>
                                <label class="mb-2 block text-sm font-black text-slate-800">
                                    Estado
                                </label>

                                <Select v-model="form.status" :pt="ptSelect" :invalid="hasErr('status')"
                                    :options="statusOptions" placeholder="Selecciona estado…"
                                    class="!w-full !rounded-2xl" />

                                <p v-if="hasErr('status')" class="mt-2 text-xs font-semibold text-red-600">
                                    {{ firstErr('status') }}
                                </p>
                            </div>

                            <!-- Contrato -->
                            <div>
                                <label class="mb-2 block text-sm font-black text-slate-800">
                                    Tipo de contrato
                                </label>

                                <Select v-model="form.contract_type" :pt="ptSelect" :invalid="hasErr('contract_type')"
                                    :options="contractOptions" placeholder="Selecciona contrato…"
                                    class="!w-full !rounded-2xl" />

                                <p v-if="hasErr('contract_type')" class="mt-2 text-xs font-semibold text-red-600">
                                    {{ firstErr('contract_type') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </template>
            </Card>

            <!-- Vista rápida -->
            <Card :pt="ptCard">
                <template #content>
                    <div class="grid gap-5 p-6 lg:grid-cols-[1fr_300px] lg:items-center">
                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                                Vista rápida
                            </p>

                            <h3 class="mt-2 text-xl font-black text-slate-950">
                                {{ form.name_job || 'Nombre de la oferta' }}
                            </h3>

                            <p class="mt-2 line-clamp-2 text-sm leading-6 text-slate-500">
                                {{ form.description || 'Aquí aparecerá una vista previa de la descripción de la oferta.'
                                }}
                            </p>

                            <div class="mt-4 flex flex-wrap gap-2">
                                <span
                                    class="inline-flex items-center gap-2 rounded-2xl bg-slate-50 px-3 py-2 text-xs font-bold text-slate-600 ring-1 ring-slate-200">
                                    <span class="material-symbols-outlined text-[16px] text-red-500">location_on</span>
                                    {{ selectedBranchLabel }}
                                </span>

                                <span
                                    class="inline-flex items-center gap-2 rounded-2xl bg-slate-50 px-3 py-2 text-xs font-bold text-slate-600 ring-1 ring-slate-200">
                                    <span class="material-symbols-outlined text-[16px] text-red-500">payments</span>
                                    $ {{ formattedSalary }}
                                </span>

                                <!--<span class="inline-flex rounded-full px-3 py-2 text-xs font-black"
                                    :class="statusBadgeClass">
                                    {{ form.status }}
                                </span>-->
                            </div>
                        </div>

                        <div class="rounded-3xl bg-slate-950 p-5 text-white">
                            <p class="text-xs font-black uppercase tracking-[0.22em] text-red-300">
                                Publicación
                            </p>

                            <p class="mt-2 text-sm leading-6 text-slate-300">
                                Al guardar, la oferta quedará disponible según el estado seleccionado.
                            </p>

                            <div
                                class="mt-4 rounded-2xl bg-white/10 px-4 py-3 text-xs font-semibold text-slate-200 ring-1 ring-white/10">
                                Estado actual:
                                <span class="font-black text-white">
                                    {{ form.status }}
                                </span>
                            </div>
                        </div>
                    </div>
                </template>
            </Card>

            <!-- Acciones -->
            <div
                class="sticky bottom-4 z-20 flex flex-col gap-3 rounded-[2rem] border border-slate-200 bg-white/95 p-4 shadow-2xl shadow-slate-300/60 backdrop-blur sm:flex-row sm:items-center sm:justify-between">
                <div class="text-sm text-slate-500">
                    <span v-if="isDirty" class="font-bold text-amber-700">
                        Tienes cambios pendientes por guardar.
                    </span>

                    <span v-else class="font-medium">
                        La información está actualizada.
                    </span>
                </div>

                <div class="flex flex-col-reverse gap-2 sm:flex-row sm:items-center">
                    <Button type="button" :pt="ptButton" outlined
                        class="!rounded-2xl !border-slate-200 !bg-white !px-5 !py-3 !text-sm !font-bold !text-slate-700 hover:!border-red-200 hover:!bg-red-50 hover:!text-red-600"
                        label="Volver" @click="back">
                        <template #icon>
                            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                        </template>
                    </Button>

                    <Button type="submit" :pt="ptButton"
                        class="!rounded-2xl !border-red-600 !bg-red-600 !px-6 !py-3 !text-sm !font-black !text-white !shadow-lg !shadow-red-600/25 hover:!border-red-700 hover:!bg-red-700 disabled:!cursor-not-allowed disabled:!opacity-60"
                        :disabled="loading" :label="loading ? 'Guardando…' : submitText">
                        <template #icon>
                            <span class="material-symbols-outlined text-[18px]">save</span>
                        </template>
                    </Button>
                </div>
            </div>
        </form>

        <!-- Confirmar salida -->
        <Dialog v-model:visible="leaveDialog" modal :draggable="false" :pt="ptDialog" class="w-full max-w-md">
            <template #header>
                <div>
                    <p class="text-xs font-black uppercase tracking-[0.18em] text-red-600">
                        Confirmación
                    </p>

                    <h3 class="mt-1 text-lg font-black text-slate-950">
                        Cambios sin guardar
                    </h3>
                </div>
            </template>

            <p class="text-sm leading-6 text-slate-600">
                Tienes cambios sin guardar. ¿Deseas salir de todas formas?
            </p>

            <template #footer>
                <div class="flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
                    <Button :pt="ptButton" outlined
                        class="!rounded-2xl !border-slate-200 !bg-white !px-4 !py-2.5 !text-sm !font-bold !text-slate-700 hover:!bg-slate-50"
                        label="Cancelar" @click="leaveDialog = false" />

                    <Button :pt="ptButton"
                        class="!rounded-2xl !border-red-600 !bg-red-600 !px-4 !py-2.5 !text-sm !font-black !text-white hover:!border-red-700 hover:!bg-red-700"
                        label="Salir" @click="forceBack" />
                </div>
            </template>
        </Dialog>
    </div>
</template>

<script setup>
import { computed, ref, watch } from 'vue';
import { useForm, router } from '@inertiajs/vue3';

// PrimeVue v4
import Card from 'primevue/card';
import Button from 'primevue/button';
import Message from 'primevue/message';
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import Select from 'primevue/select';
import InputNumber from 'primevue/inputnumber';

// PT
import {
    ptButton,
    ptMessage,
    ptDialog,
    ptInputText,
    ptTextarea,
    ptSelect,
} from '@/primevue/pt';

const props = defineProps({
    modelValue: { type: Object, default: () => ({}) },
    branches: { type: Array, default: () => [] },
    submitText: { type: String, default: 'Guardar' },
    action: { type: String, required: true },
    method: { type: String, default: 'post' },
    autosaveEnabled: { type: Boolean, default: false },
});

const form = useForm({
    name_job: props.modelValue?.name_job ?? '',
    description: props.modelValue?.description ?? '',
    salary: props.modelValue?.salary ?? 0,
    status: props.modelValue?.status ?? 'Abierta',
    contract_type: props.modelValue?.contract_type ?? 'Término Fijo',
    branch_id: props.modelValue?.branch_id ?? null,
});

const loading = computed(() => form.processing);
const autosaving = ref(false);

const leaveDialog = ref(false);
let backHref = null;

const isDirty = computed(() => form.isDirty);

const statusOptions = ['Abierta', 'Pausada', 'Cerrada'];

const contractOptions = [
    'Término Fijo',
    'Término Indefinido',
    'Obra o Labor',
    'Aprendizaje',
    'Ocasional',
    'Prestación de Servicios',
];

const branchOptions = computed(() =>
    (props.branches ?? []).map((branch) => ({
        label: branch.name ?? branch.label ?? `Sede #${branch.id}`,
        value: branch.id ?? branch.value,
    }))
);

const selectedBranchLabel = computed(() => {
    const selected = branchOptions.value.find(
        (branch) => branch.value === form.branch_id
    );

    return selected?.label ?? 'Sin sede seleccionada';
});

const formattedSalary = computed(() => {
    const value = Number(form.salary || 0);

    return new Intl.NumberFormat('es-CO').format(value);
});

const statusBadgeClass = computed(() => {
    const classes = {
        Abierta: 'bg-green-50 text-green-700 ring-1 ring-green-200',
        Pausada: 'bg-amber-50 text-amber-700 ring-1 ring-amber-200',
        Cerrada: 'bg-red-50 text-red-700 ring-1 ring-red-200',
    };

    return classes[form.status] ?? 'bg-slate-100 text-slate-600 ring-1 ring-slate-200';
});

const ptInputNumber = {
    root: () => ({
        class: 'w-full',
    }),
    input: ({ props }) => ({
        class: [
            'w-full rounded-2xl border bg-slate-50 px-4 py-3 text-sm text-slate-800 shadow-sm transition',
            'placeholder:text-slate-400 focus:border-red-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-red-500/20',
            props?.invalid
                ? '!border-red-300 !ring-4 !ring-red-100'
                : 'border-slate-200 hover:border-slate-300',
        ].join(' '),
    }),
};

const ptCard = {
    root: () => ({
        class: 'overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm',
    }),
    body: () => ({
        class: 'p-0',
    }),
    content: () => ({
        class: 'p-0',
    }),
};

function submit(silent = false) {
    const opts = {
        preserveScroll: true,
        onError: () => { },
        onSuccess: () => {
            form.defaults({ ...form.data() });
            form.reset();
        },
    };

    if (silent) {
        opts.preserveState = true;
        opts.only = [];
    }

    if (props.method === 'put') {
        form.transform((data) => ({ ...data, _method: 'PUT' })).post(props.action, opts);
    } else {
        form.post(props.action, opts);
    }
}

let timer = null;

watch(
    () => ({ ...form.data() }),
    () => {
        if (!props.autosaveEnabled) return;
        if (!isDirty.value) return;
        if (form.processing) return;

        clearTimeout(timer);

        timer = setTimeout(() => {
            autosaving.value = true;
            submit(true);

            setTimeout(() => {
                autosaving.value = false;
            }, 450);
        }, 900);
    },
    { deep: true }
);

function hasErr(key) {
    const value = form.errors?.[key];

    return Array.isArray(value) ? value.length > 0 : !!value;
}

function firstErr(key) {
    const value = form.errors?.[key];

    return Array.isArray(value) ? value[0] : value;
}

function back() {
    const href = route('reclutador.jobs.index');

    if (isDirty.value) {
        backHref = href;
        leaveDialog.value = true;
        return;
    }

    router.visit(href);
}

function forceBack() {
    leaveDialog.value = false;
    router.visit(backHref || route('reclutador.jobs.index'));
}
</script>

<style scoped>
.material-symbols-outlined {
    font-variation-settings: "FILL" 0, "wght" 500, "GRAD" 0, "opsz" 24;
}
</style>