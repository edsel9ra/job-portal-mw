<template>
  <div class="space-y-7">
    <!-- Cambios sin guardar -->
    <Message v-if="form.isDirty" :pt="ptMessage" severity="warn" :closable="false"
      class="!rounded-2xl !border !border-amber-200 !bg-amber-50 !text-amber-800">
      <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-3">
          <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-100 text-amber-700">
            <span class="material-symbols-outlined text-[20px]">warning</span>
          </div>

          <div>
            <p class="text-sm font-black">
              Tienes cambios sin guardar
            </p>
            <p class="text-xs leading-5 text-amber-700">
              Recuerda guardar tu currículum antes de salir.
            </p>
          </div>
        </div>
      </div>
    </Message>

    <form class="space-y-7" @submit.prevent="submit" enctype="multipart/form-data">
      <!-- Resumen -->
      <section class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 bg-slate-50 px-6 py-5">
          <div class="flex items-start gap-4">
            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-red-50 text-red-600">
              <span class="material-symbols-outlined">person_search</span>
            </div>

            <div>
              <p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                Resumen profesional
              </p>

              <h3 class="mt-2 text-xl font-black text-slate-950">
                Presenta tu perfil
              </h3>

              <p class="mt-1 text-sm leading-6 text-slate-500">
                Escribe una descripción breve sobre tu experiencia, fortalezas y objetivos profesionales.
              </p>
            </div>
          </div>
        </div>

        <div class="space-y-2 p-6">
          <label class="block text-sm font-black text-slate-800">
            Resumen
          </label>

          <Textarea v-model="form.summary" :pt="ptTextarea" :invalid="!!form.errors.summary" :rows="4" autoResize
            class="!w-full !rounded-2xl !border-slate-200 !bg-slate-50 !px-4 !py-3 !text-sm !leading-6 !text-slate-800 !shadow-sm placeholder:!text-slate-400 focus:!border-red-500 focus:!bg-white focus:!ring-4 focus:!ring-red-500/20"
            placeholder="Describe tu perfil profesional en pocas líneas..." />

          <p v-if="form.errors.summary" class="text-xs font-semibold text-red-500">
            {{ form.errors.summary }}
          </p>
        </div>
      </section>

      <!-- Experiencia -->
      <section class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 bg-slate-50 px-6 py-5">
          <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div class="flex items-start gap-4">
              <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-red-50 text-red-600">
                <span class="material-symbols-outlined">work_history</span>
              </div>

              <div>
                <p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                  Experiencia laboral
                </p>

                <h3 class="mt-2 text-xl font-black text-slate-950">
                  Trayectoria profesional
                </h3>

                <p class="mt-1 text-sm leading-6 text-slate-500">
                  Agrega tus experiencias laborales más importantes.
                </p>
              </div>
            </div>

            <Button type="button" :pt="ptButton" outlined
              class="!rounded-2xl !border-slate-200 !bg-white !px-4 !py-2.5 !text-sm !font-bold !text-slate-700 hover:!border-red-200 hover:!bg-red-50 hover:!text-red-600"
              label="Agregar" @click="addExp">
              <template #icon>
                <span class="material-symbols-outlined text-[18px]">add</span>
              </template>
            </Button>
          </div>
        </div>

        <div class="p-6">
          <div v-if="form.work_experience.length" class="space-y-5">
            <div v-for="(exp, i) in form.work_experience" :key="i"
              class="relative rounded-[1.5rem] border border-slate-200 bg-slate-50 p-5">
              <button type="button"
                class="absolute right-4 top-4 flex h-9 w-9 items-center justify-center rounded-xl bg-white text-slate-400 shadow-sm transition hover:bg-red-50 hover:text-red-600"
                @click="removeExp(i)">
                ✕
              </button>

              <div class="mb-5 flex items-center gap-3 pr-12">
                <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-white text-red-600 shadow-sm">
                  <span class="material-symbols-outlined text-[20px]">work</span>
                </div>

                <div>
                  <p class="text-sm font-black text-slate-900">
                    Experiencia #{{ i + 1 }}
                  </p>
                  <p class="text-xs text-slate-400">
                    Empresa, cargo y periodo laboral
                  </p>
                </div>
              </div>

              <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                  <label class="mb-2 block text-sm font-black text-slate-800">
                    Empresa
                  </label>

                  <InputText v-model="exp.company" :pt="ptInputText"
                    :invalid="!!form.errors[`work_experience.${i}.company`]"
                    class="!w-full !rounded-2xl !border-slate-200 !bg-white !px-4 !py-3 !text-sm !shadow-sm placeholder:!text-slate-400 focus:!border-red-500 focus:!ring-4 focus:!ring-red-500/20"
                    placeholder="Ej: Acme S.A." />

                  <p v-if="form.errors[`work_experience.${i}.company`]" class="mt-2 text-xs font-semibold text-red-500">
                    {{ form.errors[`work_experience.${i}.company`] }}
                  </p>
                </div>

                <div>
                  <label class="mb-2 block text-sm font-black text-slate-800">
                    Cargo
                  </label>

                  <InputText v-model="exp.position" :pt="ptInputText"
                    :invalid="!!form.errors[`work_experience.${i}.position`]"
                    class="!w-full !rounded-2xl !border-slate-200 !bg-white !px-4 !py-3 !text-sm !shadow-sm placeholder:!text-slate-400 focus:!border-red-500 focus:!ring-4 focus:!ring-red-500/20"
                    placeholder="Ej: Auxiliar administrativo" />

                  <p v-if="form.errors[`work_experience.${i}.position`]"
                    class="mt-2 text-xs font-semibold text-red-500">
                    {{ form.errors[`work_experience.${i}.position`] }}
                  </p>
                </div>
              </div>

              <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                  <label class="mb-2 block text-sm font-black text-slate-800">
                    Fecha inicio
                  </label>

                  <input v-model="exp.start_date" type="date"
                    :class="nativeDateClass(!!form.errors[`work_experience.${i}.start_date`])" />

                  <p v-if="form.errors[`work_experience.${i}.start_date`]"
                    class="mt-2 text-xs font-semibold text-red-500">
                    {{ form.errors[`work_experience.${i}.start_date`] }}
                  </p>
                </div>

                <div>
                  <label class="mb-2 block text-sm font-black text-slate-800">
                    Fecha fin
                    <span class="font-medium text-slate-400">
                      (vacío = actualidad)
                    </span>
                  </label>

                  <input v-model="exp.end_date" type="date"
                    :class="nativeDateClass(!!form.errors[`work_experience.${i}.end_date`])" />

                  <p v-if="form.errors[`work_experience.${i}.end_date`]"
                    class="mt-2 text-xs font-semibold text-red-500">
                    {{ form.errors[`work_experience.${i}.end_date`] }}
                  </p>
                </div>
              </div>

              <div class="mt-4">
                <label class="mb-2 block text-sm font-black text-slate-800">
                  Descripción
                  <span class="font-medium text-slate-400">
                    (opcional)
                  </span>
                </label>

                <Textarea v-model="exp.description" :pt="ptTextarea" :rows="2" autoResize
                  class="!w-full !rounded-2xl !border-slate-200 !bg-white !px-4 !py-3 !text-sm !leading-6 !shadow-sm placeholder:!text-slate-400 focus:!border-red-500 focus:!ring-4 focus:!ring-red-500/20"
                  placeholder="Funciones y logros principales..." />
              </div>
            </div>
          </div>

          <div v-else class="rounded-[1.5rem] border border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center">
            <div
              class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-slate-500 shadow-sm">
              <span class="material-symbols-outlined">work</span>
            </div>

            <p class="mt-4 text-sm font-black text-slate-700">
              Sin experiencia agregada
            </p>

            <p class="mt-1 text-sm text-slate-400">
              Haz clic en “Agregar” para registrar tu experiencia laboral.
            </p>
          </div>
        </div>
      </section>

      <!-- Educación -->
      <section class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 bg-slate-50 px-6 py-5">
          <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div class="flex items-start gap-4">
              <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-red-50 text-red-600">
                <span class="material-symbols-outlined">school</span>
              </div>

              <div>
                <p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                  Educación
                </p>

                <h3 class="mt-2 text-xl font-black text-slate-950">
                  Formación académica
                </h3>

                <p class="mt-1 text-sm leading-6 text-slate-500">
                  Agrega estudios, carreras, cursos técnicos o formación relevante.
                </p>
              </div>
            </div>

            <Button type="button" :pt="ptButton" outlined
              class="!rounded-2xl !border-slate-200 !bg-white !px-4 !py-2.5 !text-sm !font-bold !text-slate-700 hover:!border-red-200 hover:!bg-red-50 hover:!text-red-600"
              label="Agregar" @click="addEdu">
              <template #icon>
                <span class="material-symbols-outlined text-[18px]">add</span>
              </template>
            </Button>
          </div>
        </div>

        <div class="p-6">
          <div v-if="form.education.length" class="space-y-4">
            <div v-for="(edu, i) in form.education" :key="i"
              class="relative rounded-[1.5rem] border border-slate-200 bg-slate-50 p-5">
              <button type="button"
                class="absolute right-4 top-4 flex h-9 w-9 items-center justify-center rounded-xl bg-white text-slate-400 shadow-sm transition hover:bg-red-50 hover:text-red-600"
                @click="removeEdu(i)">
                ✕
              </button>

              <div class="grid grid-cols-1 gap-4 pr-12 md:grid-cols-3">
                <div class="md:col-span-2">
                  <label class="mb-2 block text-sm font-black text-slate-800">
                    Título
                  </label>

                  <InputText v-model="edu.title" :pt="ptInputText"
                    class="!w-full !rounded-2xl !border-slate-200 !bg-white !px-4 !py-3 !text-sm !shadow-sm placeholder:!text-slate-400 focus:!border-red-500 focus:!ring-4 focus:!ring-red-500/20"
                    placeholder="Ej: Ingeniería de Sistemas" />
                </div>

                <div>
                  <label class="mb-2 block text-sm font-black text-slate-800">
                    Año
                  </label>

                  <InputText v-model="edu.year" :pt="ptInputText" type="number"
                    class="!w-full !rounded-2xl !border-slate-200 !bg-white !px-4 !py-3 !text-sm !shadow-sm placeholder:!text-slate-400 focus:!border-red-500 focus:!ring-4 focus:!ring-red-500/20"
                    placeholder="2024" />
                </div>

                <div class="md:col-span-3">
                  <label class="mb-2 block text-sm font-black text-slate-800">
                    Institución
                  </label>

                  <InputText v-model="edu.school" :pt="ptInputText"
                    class="!w-full !rounded-2xl !border-slate-200 !bg-white !px-4 !py-3 !text-sm !shadow-sm placeholder:!text-slate-400 focus:!border-red-500 focus:!ring-4 focus:!ring-red-500/20"
                    placeholder="Ej: Universidad Libre" />
                </div>
              </div>
            </div>
          </div>

          <div v-else class="rounded-[1.5rem] border border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center">
            <div
              class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-slate-500 shadow-sm">
              <span class="material-symbols-outlined">school</span>
            </div>

            <p class="mt-4 text-sm font-black text-slate-700">
              Sin educación agregada
            </p>
          </div>
        </div>
      </section>

      <!-- Habilidades -->
      <section class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 bg-slate-50 px-6 py-5">
          <div class="flex items-start gap-4">
            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-red-50 text-red-600">
              <span class="material-symbols-outlined">psychology</span>
            </div>

            <div>
              <p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                Habilidades
              </p>

              <h3 class="mt-2 text-xl font-black text-slate-950">
                Competencias y conocimientos
              </h3>

              <p class="mt-1 text-sm leading-6 text-slate-500">
                Escribe una habilidad y presiona Enter para agregarla.
              </p>
            </div>
          </div>
        </div>

        <div class="space-y-3 p-6">
          <div @keydown.enter.prevent>
            <AutoComplete v-model="form.skills" :pt="ptAutoComplete" :invalid="!!form.errors['skills.0']" multiple
              :typeahead="false" :forceSelection="false" :suggestions="skillSuggestions" class="w-full"
              placeholder="Ej: Vue.js, Laravel, SQL, Docker..." @complete="searchSkills" />
          </div>

          <p v-if="form.errors['skills.0']" class="text-xs font-semibold text-red-500">
            {{ form.errors['skills.0'] }}
          </p>
        </div>
      </section>

      <!-- Idiomas -->
      <section class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 bg-slate-50 px-6 py-5">
          <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div class="flex items-start gap-4">
              <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-red-50 text-red-600">
                <span class="material-symbols-outlined">translate</span>
              </div>

              <div>
                <p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                  Idiomas
                </p>

                <h3 class="mt-2 text-xl font-black text-slate-950">
                  Manejo de idiomas
                </h3>
              </div>
            </div>

            <Button type="button" :pt="ptButton" outlined
              class="!rounded-2xl !border-slate-200 !bg-white !px-4 !py-2.5 !text-sm !font-bold !text-slate-700 hover:!border-red-200 hover:!bg-red-50 hover:!text-red-600"
              label="Agregar" @click="addLang">
              <template #icon>
                <span class="material-symbols-outlined text-[18px]">add</span>
              </template>
            </Button>
          </div>
        </div>

        <div class="p-6">
          <div v-if="form.languages.length" class="space-y-3">
            <div v-for="(lang, i) in form.languages" :key="i"
              class="grid grid-cols-1 gap-3 rounded-[1.5rem] border border-slate-200 bg-slate-50 p-4 sm:grid-cols-[1fr_180px_auto] sm:items-center">
              <InputText v-model="lang.name" :pt="ptInputText"
                class="!w-full !rounded-2xl !border-slate-200 !bg-white !px-4 !py-3 !text-sm !shadow-sm placeholder:!text-slate-400 focus:!border-red-500 focus:!ring-4 focus:!ring-red-500/20"
                placeholder="Ej: Inglés" />

              <Select v-model="lang.level" :pt="ptSelect" :invalid="!!form.errors[`languages.${i}.level`]"
                :options="levels" placeholder="Nivel..." class="!w-full !rounded-2xl" />

              <button type="button"
                class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-slate-400 shadow-sm transition hover:bg-red-50 hover:text-red-600"
                @click="removeLang(i)">
                ✕
              </button>
            </div>
          </div>

          <div v-else class="rounded-[1.5rem] border border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center">
            <p class="text-sm font-black text-slate-700">
              Sin idiomas agregados
            </p>
          </div>
        </div>
      </section>

      <!-- Certificaciones -->
      <section class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 bg-slate-50 px-6 py-5">
          <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div class="flex items-start gap-4">
              <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-red-50 text-red-600">
                <span class="material-symbols-outlined">workspace_premium</span>
              </div>

              <div>
                <p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                  Certificaciones
                </p>

                <h3 class="mt-2 text-xl font-black text-slate-950">
                  Cursos y certificados
                </h3>
              </div>
            </div>

            <Button type="button" :pt="ptButton" outlined
              class="!rounded-2xl !border-slate-200 !bg-white !px-4 !py-2.5 !text-sm !font-bold !text-slate-700 hover:!border-red-200 hover:!bg-red-50 hover:!text-red-600"
              label="Agregar" @click="addCert">
              <template #icon>
                <span class="material-symbols-outlined text-[18px]">add</span>
              </template>
            </Button>
          </div>
        </div>

        <div class="p-6">
          <div v-if="form.certifications.length" class="space-y-4">
            <div v-for="(cert, i) in form.certifications" :key="i"
              class="relative rounded-[1.5rem] border border-slate-200 bg-slate-50 p-5">
              <button type="button"
                class="absolute right-4 top-4 flex h-9 w-9 items-center justify-center rounded-xl bg-white text-slate-400 shadow-sm transition hover:bg-red-50 hover:text-red-600"
                @click="removeCert(i)">
                ✕
              </button>

              <div class="grid grid-cols-1 gap-4 pr-12 md:grid-cols-3">
                <div class="md:col-span-2">
                  <label class="mb-2 block text-sm font-black text-slate-800">
                    Nombre
                  </label>

                  <InputText v-model="cert.name" :pt="ptInputText"
                    class="!w-full !rounded-2xl !border-slate-200 !bg-white !px-4 !py-3 !text-sm !shadow-sm placeholder:!text-slate-400 focus:!border-red-500 focus:!ring-4 focus:!ring-red-500/20"
                    placeholder="Ej: Curso de servicio al cliente" />
                </div>

                <div>
                  <label class="mb-2 block text-sm font-black text-slate-800">
                    Año
                  </label>

                  <InputText v-model="cert.year" :pt="ptInputText" type="number"
                    class="!w-full !rounded-2xl !border-slate-200 !bg-white !px-4 !py-3 !text-sm !shadow-sm placeholder:!text-slate-400 focus:!border-red-500 focus:!ring-4 focus:!ring-red-500/20"
                    placeholder="2023" />
                </div>

                <div class="md:col-span-3">
                  <label class="mb-2 block text-sm font-black text-slate-800">
                    Institución
                  </label>

                  <InputText v-model="cert.institution" :pt="ptInputText"
                    class="!w-full !rounded-2xl !border-slate-200 !bg-white !px-4 !py-3 !text-sm !shadow-sm placeholder:!text-slate-400 focus:!border-red-500 focus:!ring-4 focus:!ring-red-500/20"
                    placeholder="Ej: SENA" />
                </div>
              </div>
            </div>
          </div>

          <div v-else class="rounded-[1.5rem] border border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center">
            <p class="text-sm font-black text-slate-700">
              Sin certificaciones agregadas
            </p>
          </div>
        </div>
      </section>

      <!-- PDF -->
      <section class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 bg-slate-50 px-6 py-5">
          <div class="flex items-start gap-4">
            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-red-50 text-red-600">
              <span class="material-symbols-outlined">picture_as_pdf</span>
            </div>

            <div>
              <p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                Hoja de vida en PDF
              </p>

              <h3 class="mt-2 text-xl font-black text-slate-950">
                Archivo adjunto
                <span class="font-medium text-slate-400">
                  (opcional)
                </span>
              </h3>

              <p class="mt-1 text-sm leading-6 text-slate-500">
                Puedes subir un archivo PDF adicional de tu hoja de vida.
              </p>
            </div>
          </div>
        </div>

        <div class="p-6">
          <div class="rounded-[1.5rem] border border-dashed border-slate-300 bg-slate-50 p-5">
            <input ref="pdfInput" type="file" accept="application/pdf"
              class="block w-full text-sm text-slate-600 file:mr-4 file:rounded-xl file:border-0 file:bg-red-50 file:px-4 file:py-2.5 file:text-sm file:font-black file:text-red-600 hover:file:bg-red-100"
              @change="onPdfChange" />

            <p v-if="form.errors.pdf_file" class="mt-2 text-xs font-semibold text-red-500">
              {{ form.errors.pdf_file }}
            </p>

            <p class="mt-3 text-xs leading-5 text-slate-400">
              Máximo 8 MB · Solo PDF
            </p>
          </div>
        </div>
      </section>

      <!-- Acciones -->
      <div
        class="sticky bottom-4 z-20 flex flex-col gap-3 rounded-[2rem] border border-slate-200 bg-white/95 p-4 shadow-2xl shadow-slate-300/60 backdrop-blur sm:flex-row sm:items-center sm:justify-between">
        <div class="text-sm text-slate-500">
          <span v-if="form.isDirty" class="font-bold text-amber-700">
            Tienes cambios pendientes por guardar.
          </span>

          <span v-else class="font-medium">
            La información está actualizada.
          </span>
        </div>

        <div class="flex flex-col-reverse gap-2 sm:flex-row sm:items-center">
          <Button type="button" :pt="ptButton" outlined
            class="!rounded-2xl !border-slate-200 !bg-white !px-5 !py-3 !text-sm !font-bold !text-slate-700 hover:!border-red-200 hover:!bg-red-50 hover:!text-red-600"
            label="Volver" @click="goBack">
            <template #icon>
              <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            </template>
          </Button>

          <Button type="submit" :pt="ptButton"
            class="!rounded-2xl !border-red-600 !bg-red-600 !px-6 !py-3 !text-sm !font-black !text-white !shadow-lg !shadow-red-600/25 hover:!border-red-700 hover:!bg-red-700 disabled:!cursor-not-allowed disabled:!opacity-60"
            :disabled="form.processing" :label="form.processing ? 'Guardando...' : submitText">
            <template #icon>
              <span class="material-symbols-outlined text-[18px]">save</span>
            </template>
          </Button>
        </div>
      </div>
    </form>
  </div>

  <!-- Modal PDF -->
  <Transition name="modal">
    <div v-if="showPdfErrorModal"
      class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/70 p-4 backdrop-blur-sm"
      @click.self="closePdfErrorModal">
      <div class="w-full max-w-md overflow-hidden rounded-[2rem] bg-white shadow-2xl shadow-black/40">
        <div
          class="relative overflow-hidden bg-gradient-to-br from-slate-950 via-slate-900 to-red-950 px-6 py-6 text-white">
          <div class="pointer-events-none absolute -right-16 -top-16 h-40 w-40 rounded-full bg-red-600/30 blur-3xl">
          </div>

          <div class="relative flex items-start justify-between gap-4">
            <div>
              <p class="text-xs font-black uppercase tracking-[0.22em] text-red-200">
                Archivo no permitido
              </p>

              <h3 class="mt-2 text-xl font-black">
                Revisa el PDF seleccionado
              </h3>

              <p class="mt-2 text-sm leading-6 text-slate-300">
                El archivo no cumple con las condiciones requeridas.
              </p>
            </div>

            <button type="button"
              class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-2xl bg-white/10 text-white transition hover:bg-white/20"
              @click="closePdfErrorModal">
              ✕
            </button>
          </div>
        </div>

        <div class="px-6 py-6">
          <p class="text-sm leading-6 text-slate-600">
            {{ pdfErrorMessage }}
          </p>

          <div class="mt-6 flex justify-end">
            <Button type="button" :pt="ptButton"
              class="!rounded-2xl !border-red-600 !bg-red-600 !px-5 !py-3 !text-sm !font-black !text-white hover:!border-red-700 hover:!bg-red-700"
              label="Entendido" @click="closePdfErrorModal" />
          </div>
        </div>
      </div>
    </div>
  </Transition>
</template>

<script setup>
import { ref } from 'vue'
import { useForm, router } from '@inertiajs/vue3'

// PrimeVue v4
import Button from 'primevue/button'
import Message from 'primevue/message'
import InputText from 'primevue/inputtext'
import Textarea from 'primevue/textarea'
import Select from 'primevue/select'
import AutoComplete from 'primevue/autocomplete'

// PT
import { ptButton, ptMessage, ptInputText, ptTextarea, ptSelect, ptAutoComplete } from '@/primevue/pt'

const pdfInput = ref(null)
const showPdfErrorModal = ref(false)
const pdfErrorMessage = ref('')

const MAX_PDF_SIZE_MB = 8
const MAX_PDF_SIZE_BYTES = MAX_PDF_SIZE_MB * 1024 * 1024

function closePdfErrorModal() {
  showPdfErrorModal.value = false
  pdfErrorMessage.value = ''
}

const props = defineProps({
  modelValue: { type: Object, default: () => ({}) },
  levels: { type: Array, default: () => [] },
  action: { type: String, required: true },
  method: { type: String, default: 'post' },
  submitText: { type: String, default: 'Guardar' },
})

// Form
const form = useForm({
  summary: props.modelValue?.summary ?? '',
  work_experience: props.modelValue?.work_experience ?? [],
  education: props.modelValue?.education ?? [],
  skills: props.modelValue?.skills ?? [],
  certifications: props.modelValue?.certifications ?? [],
  languages: props.modelValue?.languages ?? [],
  pdf_file: null,
})

function normalizeSkills(arr) {
  const seen = new Set()
  return (arr ?? [])
    .map(v => String(v ?? '').trim())
    .filter(Boolean)
    .filter(v => {
      const k = v.toLowerCase()
      if (seen.has(k)) return false
      seen.add(k)
      return true
    })
}

function submit() {
  const baseTransform = (data) => ({
    ...data,
    skills: normalizeSkills(data.skills),
  })

  if (props.method === 'put') {
    form.transform((data) => ({ ...baseTransform(data), _method: 'PUT' }))
      .post(props.action, { forceFormData: true })
  } else {
    form.transform(baseTransform)
      .post(props.action, { forceFormData: true })
  }
}

function onPdfChange(e) {
  const file = e.target.files?.[0] ?? null

  if (!file) {
    form.pdf_file = null
    return
  }

  const isPdf =
    file.type === 'application/pdf' ||
    file.name.toLowerCase().endsWith('.pdf')

  if (!isPdf) {
    form.pdf_file = null
    pdfErrorMessage.value = 'Solo se permiten archivos en formato PDF.'
    showPdfErrorModal.value = true

    if (pdfInput.value) {
      pdfInput.value.value = ''
    }

    return
  }

  if (file.size > MAX_PDF_SIZE_BYTES) {
    form.pdf_file = null
    pdfErrorMessage.value = `El archivo PDF supera el tamaño máximo permitido de ${MAX_PDF_SIZE_MB} MB. Por favor, súbelo nuevamente con un tamaño menor.`
    showPdfErrorModal.value = true

    if (pdfInput.value) {
      pdfInput.value.value = ''
    }

    return
  }

  form.pdf_file = file
}

function goBack() {
  router.visit(route('candidato.resume.show'))
}

// Skills suggestions
const skillSuggestions = ref([])

const SKILL_CATALOG = [
  'Laravel', 'PHP', 'Vue.js', 'JavaScript', 'TypeScript', 'HTML', 'CSS',
  'TailwindCSS', 'MySQL', 'PostgreSQL', 'Git', 'Docker', 'Linux',
  'REST API', 'Inertia.js', 'Vite', 'Node.js', 'AWS', 'Azure', 'Scrum'
]

function searchSkills(e) {
  const q = String(e.query ?? '').trim().toLowerCase()
  if (!q) {
    skillSuggestions.value = []
    return
  }

  const selected = new Set((form.skills ?? []).map(s => String(s).toLowerCase()))
  skillSuggestions.value = SKILL_CATALOG
    .filter(s => s.toLowerCase().includes(q))
    .filter(s => !selected.has(s.toLowerCase()))
    .slice(0, 10)
}

// Experiencia
function addExp() {
  form.work_experience.push({ company: '', position: '', start_date: '', end_date: '', description: '' })
}
function removeExp(i) { form.work_experience.splice(i, 1) }

// Educación
function addEdu() { form.education.push({ title: '', school: '', year: '' }) }
function removeEdu(i) { form.education.splice(i, 1) }

// Idiomas
function addLang() { form.languages.push({ name: '', level: '' }) }
function removeLang(i) { form.languages.splice(i, 1) }

// Certificaciones
function addCert() { form.certifications.push({ name: '', institution: '', year: '' }) }
function removeCert(i) { form.certifications.splice(i, 1) }

// input date nativo con look consistente
function nativeDateClass(isInvalid) {
  return [
    'w-full rounded-2xl border bg-white px-4 py-3 text-sm text-slate-800 shadow-sm transition',
    'focus:border-red-500 focus:outline-none focus:ring-4 focus:ring-red-500/20',
    isInvalid ? '!border-red-300 !ring-4 !ring-red-100' : 'border-slate-200 hover:border-slate-300',
  ].join(' ')
}
</script>

<style scoped>
.material-symbols-outlined {
  font-variation-settings: "FILL" 0, "wght" 500, "GRAD" 0, "opsz" 24;
}

.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.2s ease;
}

.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}
</style>