declare var HandTrackerThreeHelper: any;
declare var PoseFlipFilter: any;
declare var THREE: any;
declare var WEBARROCKSHAND: any;

import { Component, Input, OnDestroy } from '@angular/core';
import { BehaviorSubject } from 'rxjs';

@Component({
  selector: 'app-canvas',
  templateUrl: './canvas.component.html',
  styleUrls: ['./canvas.component.scss']
})
export class CanvasComponent implements OnDestroy {
  private three: any;
  private _isMirroredMode = false;
  private _loadedShoe: any = null;
  private resizeListener: any;
  private animationFrameId: any;

  private prevFootPos: any = null;
  private prevQuat: any = null;
  private prevScale = 1;

  @Input() threshold!: number;
  @Input() shoeRightPath!: BehaviorSubject<string>;
  @Input() modeName!: string;
  @Input() scale!: number;
  @Input() translation!: number[];
  @Input() debugCube!: boolean;
  @Input() scanSettings!: any;
  @Input() NNsPaths!: string[];

  private _settings: any;
  private _state = -1;

  constructor() {}

  ngOnInit() {
    this._settings = {
      threshold: this.threshold,
      shoeRightPath: null,
      occluderPath: 'assets/3d-models/occluder.glb',
      scale: this.scale,
      translation: this.translation,
      debugCube: this.debugCube,
      debugDisplayLandmarks: false,
      isModelLightMapped: true
    };

    this.shoeRightPath.subscribe((s) => {
      this._settings.shoeRightPath = s;
      if (this._state !== -1) {
        this.loadShoe(s);
      }
    });

    this.main();

    // ✅ Auto-resize canvas for responsiveness
    this.resizeListener = () => {
      const handTrackerCanvas = document.getElementById('handTrackerCanvas');
      const VTOCanvas = document.getElementById('ARCanvas');
      this.setFullScreen(handTrackerCanvas);
      this.setFullScreen(VTOCanvas);
      if (this.three) this.three.renderer.setSize(window.innerWidth, window.innerHeight);
    };
    window.addEventListener('resize', this.resizeListener);
  }

  ngOnDestroy() {
    window.removeEventListener('resize', this.resizeListener);
    cancelAnimationFrame(this.animationFrameId);
  }

  setFullScreen(cv: any) {
    if (!cv) return;
    cv.width = window.innerWidth;
    cv.height = window.innerHeight;
  }

  main() {
    this._state = 0;
    const handTrackerCanvas = document.getElementById('handTrackerCanvas');
    const VTOCanvas = document.getElementById('ARCanvas');

    this.setFullScreen(handTrackerCanvas);
    this.setFullScreen(VTOCanvas);

    const initParams: any = {
      poseLandmarksLabels: [
        'ankleBack', 'ankleOut', 'ankleIn', 'ankleFront',
        'heelBackOut', 'heelBackIn',
        'pinkyToeBaseTop', 'middleToeBaseTop', 'bigToeBaseTop'
      ],
      enableFlipObject: true,
      cameraZoom: 1,
      freeZRot: false,
      threshold: this._settings.threshold,
      scanSettings: this.scanSettings,
      VTOCanvas: VTOCanvas,
      handTrackerCanvas: handTrackerCanvas,
      debugDisplayLandmarks: this._settings.debugDisplayLandmarks,
      NNsPaths: this.NNsPaths,
      maxHandsDetected: 2,
    };

    HandTrackerThreeHelper.init(initParams)
      .then((three: any) => {
        this.three = three;
        if (this._settings.shoeRightPath) this.loadShoe(this._settings.shoeRightPath);
        this.start(three);
      })
      .catch((err: any) => console.error('Init error:', err));
  }

  start(three: any) {
    if (!three) return;
    HandTrackerThreeHelper.clear_threeObjects(true);

    three.renderer.toneMapping = THREE.ACESFilmicToneMapping;
    three.renderer.outputEncoding = THREE.sRGBEncoding;

    const light = new THREE.PointLight(0xffffff, 0);
    const ambient = new THREE.AmbientLight(0xffffff, 0.0);
    three.scene.add(light, ambient);

    three.camera.scale.x = this._isMirroredMode ? -1 : 1;

    if (this._settings.debugCube) {
      const cube = new THREE.Mesh(
        new THREE.BoxGeometry(0.1, 0.1, 0.1),
        new THREE.MeshNormalMaterial()
      );
      HandTrackerThreeHelper.add_threeObject(cube);
    }

    this._state = 1;

    // ✅ Live update tracking loop
    const update = () => {
      if (this._loadedShoe) this.updateShoeFit();
      this.animationFrameId = requestAnimationFrame(update);
    };
    update();
  }

  // ✅ Adaptive, smoother, more accurate shoe fitting
  updateShoeFit() {
    try {
      const lm = HandTrackerThreeHelper.get_Landmarks();
      if (!lm || !lm.ankleFront || !lm.heelBackIn) return;

      const ankle = new THREE.Vector3().fromArray(lm.ankleFront);
      const heel = new THREE.Vector3().fromArray(lm.heelBackIn);

      // Position → average midpoint for stability
      const footCenter = new THREE.Vector3().addVectors(ankle, heel).multiplyScalar(0.5);
      const footDir = new THREE.Vector3().subVectors(ankle, heel).normalize();

      // Smoothing factor (higher = slower, smoother)
      const smoothFactor = 0.2;

      if (!this.prevFootPos) {
        this.prevFootPos = footCenter.clone();
        this.prevQuat = new THREE.Quaternion();
      }

      // ✅ Smooth position
      this.prevFootPos.lerp(footCenter, smoothFactor);

      // ✅ Rotation alignment (foot direction)
      const forward = new THREE.Vector3(0, 0, 1);
      const quat = new THREE.Quaternion().setFromUnitVectors(forward, footDir);
      this.prevQuat.slerp(quat, smoothFactor);

      // ✅ Estimate scale by foot length
      const footLength = ankle.distanceTo(heel);
      const newScale = THREE.MathUtils.lerp(this.prevScale, footLength * 9 * this._settings.scale, 0.3);
      this.prevScale = newScale;

      // ✅ Apply final transform
      this._loadedShoe.position.copy(this.prevFootPos);
      this._loadedShoe.position.y -= 0.02; // height correction
      this._loadedShoe.setRotationFromQuaternion(this.prevQuat);
      this._loadedShoe.rotateX(-Math.PI / 2);
      this._loadedShoe.scale.setScalar(newScale);

      // ✅ Apply translation offset
      const t = new THREE.Vector3().fromArray(this._settings.translation);
      this._loadedShoe.position.add(t);
    } catch (e) {
      console.warn('updateShoeFit error:', e);
    }
  }

  loadShoe(path: string) {
    if (!path) return;

    if (this._loadedShoe) {
      HandTrackerThreeHelper.clear_threeObjects(true);
      this._loadedShoe = null;
    }

    new THREE.GLTFLoader().load(
      path,
      (gltf: any) => {
        this._loadedShoe = gltf.scene;
        this._loadedShoe.traverse((child: any) => {
          if (child.isMesh) {
            child.castShadow = true;
            child.receiveShadow = true;
            if (child.material.map) child.material.map.encoding = THREE.sRGBEncoding;
          }
        });

        HandTrackerThreeHelper.add_threeObject(this._loadedShoe);
        console.log('✅ Shoe loaded and fitted:', path);
      },
      undefined,
      (err: any) => console.error('Shoe load error:', path, err)
    );

    // ✅ Occluder
    new THREE.GLTFLoader().load(this._settings.occluderPath, (gltf: any) => {
      const occ = gltf.scene.children[0];
      HandTrackerThreeHelper.add_threeOccluder(occ);
    });
  }

  flip_camera() {
    if (this._state !== 1) return;
    this._state = 2;

    WEBARROCKSHAND.update_videoSettings({
      facingMode: this._isMirroredMode ? 'environment' : 'user'
    }).then(() => {
      this._isMirroredMode = !this._isMirroredMode;
      this._state = 1;

      const canvases = document.getElementById('canvases')!;
      canvases.style.transition = 'transform 0.3s';
      canvases.style.transform = this._isMirroredMode ? 'rotateY(180deg)' : '';

      this.start(this.three);
      console.log('Camera flipped → Mirror mode:', this._isMirroredMode);
    }).catch((err: any) => console.error('Flip camera error:', err));
  }
}