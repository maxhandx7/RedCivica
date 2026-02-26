<style>
    

  #loadingOverlay {
    position: fixed;
    inset: 0;
    z-index: 9999;
    display: none;
    align-items: center;
    justify-content: center;
    background: rgba(0, 0, 0, 0.6);
  }

  #loadingOverlay.active {
    display: flex;
  }

  .simple-spinner {
    width: 50px;
    height: 50px;
    border: 4px solid rgba(255,255,255,0.2);
    border-top: 4px solid #0d6efd;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
  }

  @keyframes spin {
    to { transform: rotate(360deg); }
  }
</style>



<div id="loadingOverlay">
  <div class="simple-spinner"></div>
</div>



   <script>
  const LoadingScreen = {
    show() {
      document.getElementById('loadingOverlay').classList.add('active');
    },
    hide() {
      document.getElementById('loadingOverlay').classList.remove('active');
    }
  };
</script>
