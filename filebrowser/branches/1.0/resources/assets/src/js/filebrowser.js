'use strict'

import Observer from '@pollen-solutions/support/resources/assets/src/js/mutation-observer'
import Dropzone from 'dropzone'
import PdfViewer from '@pollen-solutions/pdf/resources/assets/src/js/partial/pdf-viewer'
import '@pollen-solutions/partial/resources/assets/src/js/notice'

class Filebrowser {
  constructor(el, options = {}) {
    this.initialized = false
    this.verbose = true

    this.el = el

    this.options = {}
    this._initOptions(options)
    this.endpoint = this.option('endpoint')

    this._initControls()
    this._initEvents()

    this._init()
  }

  // PLUGINS
  // -------------------------------------------------------------------------------------------------------------------
  // Initialisation des options
  _initOptions(options) {
    let tagOptions = this.el.dataset.options

    if (tagOptions !== undefined) {
      try {
        tagOptions = decodeURIComponent(tagOptions)
      } catch (e) {
        if (this.verbose) console.warn(e)
      }

      try {
        tagOptions = JSON.parse(tagOptions)
      } catch (e) {
        if (this.verbose) console.warn(e)
      }
    } else {
      tagOptions = {}
    }

    if (typeof tagOptions === 'object' && tagOptions !== null) {
      Object.assign(this.options, tagOptions)
    }

    Object.assign(this.options, options)
  }

  // Resolution d'objet depuis une clé à point
  _objResolver(dotKey, obj) {
    return dotKey.split('.').reduce(function (prev, curr) {
      return prev ? prev[curr] : null
    }, obj || self)
  }

  // Initialisation
  _init() {
    this.initialized = true

    if (this.verbose) console.log('Filebrowser fully initialized')
  }

  // Initialisation
  _destroy() {
    this.initialized = true
  }

  // INITIALISATIONS
  // -------------------------------------------------------------------------------------------------------------------

  // Initialisation des éléments de contrôle.
  _initControls() {
    this.notifier = undefined
    this._initNotifier()

    this.sidebar = undefined
    this.sidebarSelected = undefined
    this.sidebarSelectinfo = undefined
    this.sidebarRename = undefined
    this.sidebarDelete = undefined
    this.sidebarPath = undefined
    this.sidebarPathinfo = undefined
    this.sidebarCreate = undefined
    this.sidebarUpload = undefined
    this._initSidebar()

    this.view = undefined
    this.viewBreadcrumb = undefined
    this.viewSwitcher = undefined
    this.viewFileCards = undefined
    this._initView()

    if (this.verbose) console.log('Filebrowser controls initialized')
  }
  _initNotifier() {
    this.notifier = this.el.querySelector('[data-filebrowser="notifier"]')
  }
  _initSidebar() {
    this.sidebar = this.el.querySelector('[data-filebrowser="sidebar"]')
    this.sidebarSelected = this.sidebar.querySelector('[data-filebrowser="sidebar.selected"]')
    this.sidebarSelectinfo = this.sidebar.querySelector('[data-filebrowser="selectinfo"]')
    this.sidebarRename = this.sidebar.querySelector('[data-filebrowser="rename"]')
    this.sidebarDelete = this.sidebar.querySelector('[data-filebrowser="delete"]')
    this.sidebarPath = this.sidebar.querySelector('[data-filebrowser="sidebar.path"]')
    this.sidebarPathinfo = this.sidebar.querySelector('[data-filebrowser="pathinfo"]')
    this.sidebarCreate = this.sidebar.querySelector('[data-filebrowser="create"]')
    this.sidebarUpload = this.sidebar.querySelector('[data-filebrowser="upload"]')
    this._initSidebarUploader()
  }
  _initSidebarUploader() {
    const exists = this.sidebarUpload.dropzone

    if (exists === undefined) {
      const self = this,
            path = this.sidebarUpload.querySelector('[name="path"]').value

      new Dropzone(this.sidebarUpload, {
        url: this.endpoint,
        createImageThumbnails: false,
        success: function (File, resp) {
          if (!resp.success) {
            self._doNotify(resp.data)
          }
        },
        sending: function (File, XMLHttpRequest, FormData) {
          FormData.set('fullPath', File.fullPath)
        },
        complete: function (File) {
          this.removeFile(File)
        },
        queuecomplete: function () {
          self._onBrowse(path)
        }
      })
    }
  }
  _initView() {
    this.view = this.el.querySelector('[data-filebrowser="view"]')
    this.viewBreadcrumb = this.view.querySelector('[data-filebrowser="breadcrumb"]')
    this.viewSwitcher = this.view.querySelector('[data-filebrowser="switcher"]')
    this.viewFileCards = this.view.querySelector('[data-filebrowser="file-cards"]')
  }
  // Initialize events
  _initEvents() {
    document.addEventListener('submit', e => {
      if (e.target.matches('[data-filebrowser="create"]')) {
        e.preventDefault()
        let data = this._serializeForm(e.target)
        this._onCreateDir(data.path, data.name)
      } else if (e.target.matches('[data-filebrowser="rename"]')) {
        e.preventDefault()
        let data = this._serializeForm(e.target)
        this._onRename(data.path, data.name)
      } else if (e.target.matches('[data-filebrowser="delete"]')) {
        e.preventDefault()
        let data = this._serializeForm(e.target)
        this._onDelete(data.path)
      }
    }, false)

    document.addEventListener('click', e => {
      if (e.target.matches('[data-filebrowser="panel.toggle"]')) {
        e.preventDefault()
        const $target = this.sidebar.querySelector(e.target.dataset.target)
        if ($target) {
          $target.classList.toggle('opened')
        }
        const resetForm = e.target.dataset.reset
        if (resetForm) {
          const $form = this.sidebar.querySelector(resetForm.toString())
          if ($form) $form.reset()
        }
      } else if (e.target.matches('[data-filebrowser="breadcrumb.link"]')) {
        e.preventDefault()
        this._onBrowse(e.target.dataset.path)
      } else if (e.target.matches('[data-filebrowser="switcher.toggle"]')) {
        e.preventDefault()
        this.view.dataset.view = e.target.dataset.toggle
      } else if (e.target.matches('[data-filebrowser="file-card"]')) {
        e.preventDefault()
        if (e.detail === 1) {
          for (let sibling of e.target.parentNode.children) {
            sibling.classList.remove('selected')
          }
          e.target.classList.add('selected')
          this._onSelect(e.target.dataset.path)
        } else if (e.detail === 2) {
          this._onBrowse(e.target.dataset.path)
        }
      }
      for (let node = e.target; node !== document.body; node = node.parentNode) {
        let data = node.dataset.filebrowser
        if (data && (data === 'file-card')) {
          break
        } else if (data && (data === 'file-cards')) {
          const $fileCardsSelected = this.viewFileCards.querySelectorAll('[data-filebrowser="file-card"].selected')
          $fileCardsSelected.forEach($fileCardSelected => {
            $fileCardSelected.classList.remove('selected')
          })
          this._onSelect('')
        }
      }
    }, false)

    if (this.verbose) console.log('Filebrowser events initialized')
  }
  // EVENTS
  // -------------------------------------------------------------------------------------------------------------------
  _onBrowse(path) {
    const data = {
          action: 'browse',
          args: [path]
        },
        successFb = data => {
          this._doReplaceViewBreadcrumb(data.viewBreadcrumb)
          this._doReplaceViewFileCards(data.viewFileCards)
          this._doReplaceSidebarSelectinfo(data.sidebarSelectinfo)
          this._doReplaceSidebarRename(data.sidebarRename)
          this._doReplaceSidebarDelete(data.sidebarDelete)
          this._doReplaceSidebarPathinfo(data.sidebarPathinfo)
          this._doReplaceSidebarCreate(data.sidebarCreate)
          this._doReplaceSidebarUpload(data.sidebarUpload)
        }
    this._doFetch(data, successFb)

    this.sidebarSelected.classList.add('hidden')
  }
  _onSelect(path) {
    const data = {
          action: 'select',
          args: [path]
        },
        successFb = data => {
          this._doReplaceSidebarSelectinfo(data.sidebarSelectinfo)
          this._doReplaceSidebarRename(data.sidebarRename)
          this._doReplaceSidebarDelete(data.sidebarDelete)
        }
    this._doFetch(data, successFb)

    if (path) {
      this.sidebarSelected.classList.remove('hidden')
    } else {
      this.sidebarSelected.classList.add('hidden')
    }
  }
  _onCreateDir(path, name) {
    const data = {
          action: 'createDir',
          args: [path, name]
        },
        successFb = data => {
          this._doReplaceViewBreadcrumb(data.viewBreadcrumb)
          this._doReplaceViewFileCards(data.viewFileCards)
          this._doReplaceSidebarSelectinfo(data.sidebarSelectinfo)
          this._doReplaceSidebarRename(data.sidebarRename)
          this._doReplaceSidebarDelete(data.sidebarDelete)
          this.sidebarCreate.reset()
          this.sidebarSelected.classList.remove('hidden')
        }
    this._doFetch(data, successFb)
  }
  _onDelete(path) {
    const data = {
          action: 'delete',
          args: [path]
        },
        successFb = data => {
          this._doReplaceViewBreadcrumb(data.viewBreadcrumb)
          this._doReplaceViewFileCards(data.viewFileCards)
          this._doReplaceSidebarSelectinfo(data.sidebarSelectinfo)
          this._doReplaceSidebarRename(data.sidebarRename)
          this._doReplaceSidebarDelete(data.sidebarDelete)
          this.sidebarSelected.classList.add('hidden')
        }
    this._doFetch(data, successFb)
  }
  _onRename(path, name) {
    const data = {
          action: 'rename',
          args: [path, name]
        },
        successFb = data => {
          this._doReplaceViewBreadcrumb(data.viewBreadcrumb)
          this._doReplaceViewFileCards(data.viewFileCards)
          this._doReplaceSidebarSelectinfo(data.sidebarSelectinfo)
          this._doReplaceSidebarRename(data.sidebarRename)
          this._doReplaceSidebarDelete(data.sidebarDelete)
        }
    this._doFetch(data, successFb)
  }
  // ACTIONS
  // -------------------------------------------------------------------------------------------------------------------
  _serializeForm($form) {
    let data = {},
        form = new FormData($form)
    for (let key of form.keys()) {
      data[key] = form.get(key)
    }
    return data
  }

  _doFetch(data, successFb) {
    const errorFb = data => {
      this._doNotify(data)
    }
    fetch(this.endpoint, {
      method: 'POST',
      headers: {
        'Content-type': 'application/json; charset=UTF-8',
        'X-Requested-with': 'XMLHttpRequest'
      },
      body: JSON.stringify(data),
    }).then(response => {
      if (response.ok) {
        return response.json()
      } else {
        if (this.verbose) console.warn(response.status)

        return Promise.reject(response)
      }
    }).then(json => {
      if (json.success) {
        successFb(json.data)
      } else {
        errorFb(json.data)
      }
    }).catch(e => {
      if (this.verbose) console.error(e)
    })
  }
  _doNotify(html) {
    this.notifier.innerHTML = html
  }
  _doReplaceSidebarSelectinfo(html) {
    this.sidebarSelectinfo.outerHTML = html
    this.sidebarSelectinfo = this.sidebar.querySelector('[data-filebrowser="selectinfo"]')
  }
  _doReplaceSidebarRename(html) {
    this.sidebarRename.outerHTML = html
    this.sidebarRename = this.sidebar.querySelector('[data-filebrowser="rename"]')
  }
  _doReplaceSidebarDelete(html) {
    this.sidebarDelete.outerHTML = html
    this.sidebarDelete = this.sidebar.querySelector('[data-filebrowser="delete"]')
  }
  _doReplaceSidebarPathinfo(html) {
    this.sidebarPathinfo.outerHTML = html
    this.sidebarPathinfo = this.sidebar.querySelector('[data-filebrowser="pathinfo"]')
  }
  _doReplaceSidebarCreate(html) {
    this.sidebarCreate.outerHTML = html
    this.sidebarCreate = this.sidebar.querySelector('[data-filebrowser="create"]')
  }
  _doReplaceSidebarUpload(html) {
    this.sidebarUpload.outerHTML = html
    this.sidebarUpload = this.sidebar.querySelector('[data-filebrowser="upload"]')
    this._initSidebarUploader()
  }
  _doReplaceViewBreadcrumb(html) {
    this.viewBreadcrumb.outerHTML = html
    this.viewBreadcrumb = this.view.querySelector('[data-filebrowser="breadcrumb"]')
  }
  _doReplaceViewFileCards(html) {
    this.viewFileCards.outerHTML = html
    this.viewFileCards = this.view.querySelector('[data-filebrowser="file-cards"]')
  }

  // ACCESSEURS
  // -----------------------------------------------------------------------------------------------------------------
  // Récupération d'options (syntaxe à point permise)
  option(key = null, defaults = null) {
    if (key === null) {
      return this.options
    }
    return this._objResolver(key, this.options) ?? defaults
  }
}

window.addEventListener('load', () => {
  const $elements = document.querySelectorAll('[data-observe="filebrowser"]')
  if ($elements) {
    for (const $el of $elements) {
      new Filebrowser($el)
    }
  }
  Observer('[data-observe="filebrowser"]', function ($el) {
    new Filebrowser($el)
  })
})

export default Filebrowser